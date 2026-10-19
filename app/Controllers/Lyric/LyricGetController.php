<?php

namespace App\Controllers\Lyric;

use App\Controllers\BaseController;
use App\Services\Lyric\LyricFinderService;

class LyricGetController extends BaseController
{
    private LyricFinderService $lyricFinderService;

    public function __construct()
    {
        $this->lyricFinderService = new LyricFinderService();
    }

    /**
     * GET /api/lyrics?id_track={id}&artista={artista}&titulo={titulo}
     */
    public function obtener()
    {
        $idTrack = $this->request->getGet('id_track');
        $artista = $this->request->getGet('artista');
        $titulo  = $this->request->getGet('titulo');

        if (!$idTrack || !$artista || !$titulo) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON(['error' => 'Faltan parámetros: id_track, artista y titulo son requeridos']);
        }

        try {
            $resultado = $this->lyricFinderService->obtenerLetra((int) $idTrack, $artista, $titulo);

            return $this->response->setJSON($resultado);

        } catch (\RuntimeException $e) {
            return $this->response
                ->setStatusCode($e->getCode() ?: 404)
                ->setJSON(['error' => $e->getMessage()]);

        } catch (\Exception $e) {
            log_message('error', 'Error en LyricGetController::obtener: ' . $e->getMessage());
            return $this->response
                ->setStatusCode(500)
                ->setJSON(['error' => 'Error interno del servidor']);
        }
    }
}