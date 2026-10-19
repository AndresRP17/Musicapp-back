<?php

namespace App\Services\Album;

use App\Models\AlbumModel;
use App\Models\TrackModel;
use App\Entity\Albums\Album;
use App\Entity\Tracks\Track;
use App\Services\Track\DeezerPreviewService;
use Config\Services;

final class AlbumCreatorService
{
    private AlbumModel $albumModel;
    private TrackModel $trackModel;
    private DeezerPreviewService $deezerPreviewService;
    private string $lastFmApiKey = 'aa182e9e95ab101a5f7ae68eba441e09'; // TODO: mover a .env

    public function __construct()
    {
        $this->albumModel = new AlbumModel();
        $this->trackModel = new TrackModel();
        $this->deezerPreviewService = new DeezerPreviewService();
    }

    /**
     * Punto de entrada: busca en la base, si no está lo pide a Last.fm y lo guarda.
     * Devuelve un array listo para convertir a JSON en el Controller.
     */
    public function obtenerAlbum(string $name, string $artist): array
    {
        // 1. Preguntamos primero a NUESTRA base de datos
        $albumExistente = $this->albumModel->findByNameAndArtist($name, $artist);

        if ($albumExistente !== null) {
            $tracks = $this->trackModel->findByAlbumId($albumExistente->getId());
            return $this->armarRespuesta($albumExistente, $tracks);
        }

        // 2. No estaba — lo pedimos a Last.fm, igual que antes hacía React directo
        $datosExternos = $this->pedirALastFm($name, $artist);

        if ($datosExternos === null) {
            throw new \RuntimeException('Álbum no encontrado', 404);
        }

        // 3. Armamos el Entity nuevo (todavía sin id real, se lo pone la BD al insertar)
        $albumNuevo = new Album(
            0, // id provisorio, el insert() de tu Model devuelve uno nuevo con el id real
            $datosExternos['name'],
            $datosExternos['artist'],
            $this->extraerImagen($datosExternos['image'] ?? []),
            $datosExternos['wiki']['summary'] ?? null,
            $datosExternos['tags']['tag'][0]['name'] ?? null,
            date('Y-m-d H:i:s')
        );

        $albumGuardado = $this->albumModel->insert($albumNuevo);

        // 4. Guardamos los tracks que vinieron de Last.fm, con su preview de Deezer
        $tracksRaw = $datosExternos['tracks']['track'] ?? [];
        if (isset($tracksRaw['name'])) {
            $tracksRaw = [$tracksRaw]; // Last.fm a veces manda un solo track como objeto, no array
        }

        $tracksGuardados = [];
        foreach ($tracksRaw as $orden => $trackRaw) {
            // Buscamos el preview UNA sola vez acá; queda guardado en la BD para siempre
            $previewUrl = $this->deezerPreviewService->buscarPreview(
                $albumGuardado->getArtist(),
                $trackRaw['name']
            );

            $trackNuevo = new Track(
                null,
                $albumGuardado->getId(),
                $trackRaw['name'],
                (int) ($trackRaw['duration'] ?? 0),
                $previewUrl,
                $orden
            );
            $tracksGuardados[] = $this->trackModel->insert($trackNuevo);
        }

        return $this->armarRespuesta($albumGuardado, $tracksGuardados);
    }

    private function pedirALastFm(string $name, string $artist): ?array
    {
        try {
            $client = Services::curlrequest();

            $response = $client->get('https://ws.audioscrobbler.com/2.0/', [
                'query' => [
                    'method'      => 'album.getinfo',
                    'api_key'     => $this->lastFmApiKey,
                    'artist'      => $artist,
                    'album'       => $name,
                    'format'      => 'json',
                    'autocorrect' => 1,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data['album'] ?? null;
        } catch (\Exception $e) {
            log_message('error', 'Error pidiendo a Last.fm: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Last.fm devuelve un array de imágenes en distintos tamaños (small, medium, large, extralarge, mega).
     * No siempre vienen los 4-5 tamaños, así que buscamos la mejor disponible sin asumir el índice fijo.
     */
    private function extraerImagen(array $images): ?string
    {
        if (empty($images)) {
            return null;
        }

        // Recorremos de la última (mejor calidad) hacia la primera
        for ($i = count($images) - 1; $i >= 0; $i--) {
            if (!empty($images[$i]['#text'])) {
                return $images[$i]['#text'];
            }
        }

        return null;
    }

    /**
     * @param Track[] $tracks
     */
    private function armarRespuesta(Album $album, array $tracks): array
    {
        return [
            'id'          => $album->getId(),
            'nombre'      => $album->getName(),
            'artista'     => $album->getArtist(),
            'portada_url' => $album->getPortada(),
            'descripcion' => $album->getDescription(),
            'genero'      => $album->getGenre(),
            'tracks'      => array_map(function (Track $track) {
                return [
                    'id'       => $track->getId(),
                    'nombre'   => $track->getName(),
                    'duracion' => $track->getDuration(),
                    'preview'  => $track->getUrl(),
                    'orden'    => $track->getOrden(),
                    'offset'   => $track->getOffsetPreview(),
                ];
            }, $tracks),
        ];
    }
}