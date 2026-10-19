<?php

namespace App\Services\Lyric;

use App\Models\LyricModel;
use App\Entity\Lyrics\Lyric;
use Config\Services;

final class LyricFinderService{

    private LyricModel $lyricsModel;

    public function __construct()
    {
        $this->lyricsModel = new LyricModel();
    }

    public function obtenerLetra(int $idTrack, string $artista, string $titulo): array
    {
        // 1. Preguntamos primero a NUESTRA base de datos
        $existente = $this->lyricsModel->findByTrackId($idTrack);
        if ($existente !== null) {
            return $this->armarRespuesta($existente);
        }

        // 2. No estaba — la pedimos a lrclib.net
        $datosLrc = $this->pedirALrclib($artista, $titulo);
        if ($datosLrc === null) {
            throw new \RuntimeException('Letra no encontrada', 404);
        }

        // 3. La guardamos para la próxima vez
        $lyricsNueva = new Lyric(
            null,
            $idTrack,
            $datosLrc['syncedLyrics'] ?? null,
            $datosLrc['plainLyrics'] ?? null,
            date('Y-m-d H:i:s')
        );
        $lyricsGuardada = $this->lyricsModel->insert($lyricsNueva);

        return $this->armarRespuesta($lyricsGuardada);
    }

    private function pedirALrclib(string $artista, string $titulo): ?array
    {
        try {
            $client = Services::curlrequest();

            $response = $client->get('https://lrclib.net/api/get', [
                'query' => [
                    'artist_name' => $artista,
                    'track_name'  => $titulo,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            // lrclib devuelve un objeto directo (no envuelto), con syncedLyrics/plainLyrics
            if (empty($data) || (!isset($data['syncedLyrics']) && !isset($data['plainLyrics']))) {
                return null;
            }

            return $data;

        } catch (\Exception $e) {
            log_message('error', 'Error pidiendo letra a lrclib.net: ' . $e->getMessage());
            return null;
        }
    }

    private function armarRespuesta(Lyric $lyric): array
    {
        return [
            'id' => $lyric->getId(),
            'id_track' => $lyric->getIdTrack(),
            'letra_sincronizada'  => $lyric->getLetra(),
            'letra_plana'  => $lyric->getLetraPlana(),
        ];
    }
}