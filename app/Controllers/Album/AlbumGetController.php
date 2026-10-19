<?php

namespace App\Controllers\Album;

use App\Controllers\BaseController;
use App\Services\Album\AlbumCreatorService;

class AlbumGetController extends BaseController
{
    private AlbumCreatorService $albumService;

    public function __construct()
    {
        $this->albumService = new AlbumCreatorService();
    }

    
    public function obtener()
    {
        $nombre = $this->request->getGet('nombre');
        $artista = $this->request->getGet('artista');

        if (!$nombre || !$artista) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['error' => 'Faltan parámetros: nombre y artista son requeridos']);
        }

        try {
            $resultado = $this->albumService->obtenerAlbum($nombre, $artista);

            return $this->response->setJSON($resultado);

        } catch (\RuntimeException $e) {
            return $this->response
                ->setStatusCode($e->getCode() ?: 404)
                ->setJSON(['error' => $e->getMessage()]);

        } catch (\Exception $e) {
            log_message('error', 'Error en AlbumGetController::obtener: ' . $e->getMessage());
            return $this->response
                ->setStatusCode(500)
                ->setJSON(['error' => 'Error interno del servidor']);
        }
    }


public function buscarPorGenero()
{
    $genero = $this->request->getGet('genero');

    if (!$genero) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON(['error' => 'Falta el parámetro genero']);
    }

    $albumModel = new \App\Models\AlbumModel();
    $albumes = $albumModel->findByGenre($genero);

    $respuesta = array_map(function ($album) {
        return [
            'id'          => $album->getId(),
            'nombre'      => $album->getName(),
            'artista'     => $album->getArtist(),
            'portada_url' => $album->getPortada(),
            'genero'      => $album->getGenre(),
        ];
    }, $albumes);

    return $this->response->setJSON($respuesta);
}
}