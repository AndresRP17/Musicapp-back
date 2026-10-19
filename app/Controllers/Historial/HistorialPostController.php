<?php

namespace App\Controllers\Historial;

use App\Controllers\BaseController;
use App\Models\HistorialModel;
use App\Models\MusicUserModel;
use App\Models\TrackModel;

class HistorialPostController extends BaseController
{
    private HistorialModel $historialModel;

    public function __construct()
    {
        $this->historialModel = new HistorialModel();
    }


    public function create()
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        $userModel = new MusicUserModel();
        $usuario = $userModel->findByToken($token);

        if (!$usuario) {
            return $this->response->setStatusCode(401)->setJSON(['error' => 'Token inválido o expirado.']);
        }

        $body = $this->request->getJSON();

        $idTrack = $body->id_track ?? null;

        // Si no vino id_track (favoritos/playlist no lo guardan), intentamos
        // encontrarlo buscando por nombre + artista en nuestra tabla tracks
        if (!$idTrack && isset($body->titulo, $body->artist)) {
            $trackModel = new TrackModel();
            $idTrack = $trackModel->findByNombreYArtista($body->titulo, $body->artist);
        }

        if (!$idTrack) {
            // No lo encontramos en tracks; no hay nada que loguear con sentido
            return $this->response->setJSON(['ok' => false, 'motivo' => 'track no encontrado en cache']);
        }

        $this->historialModel->insert($usuario->getId(), (int) $idTrack);

        return $this->response->setJSON(['ok' => true]);
    }
}