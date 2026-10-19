<?php

namespace App\Controllers\Playlist;

use App\Services\Playlist\PlaylistSearcherService;
use App\Models\MusicUserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PlaylistsGetController extends ResourceController
{
    private PlaylistSearcherService $searcher;

    public function __construct()
    {
        $this->searcher = new PlaylistSearcherService();
    }

    public function search(): ResponseInterface
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        $userModel = new MusicUserModel();
        $usuario = $userModel->findByToken($token);

        if (!$usuario) {
            return $this->failUnauthorized('No tienes permiso para ver estas playlists.');
        }

        $playlists = $this->searcher->searchByUserId($usuario->getId());

        return $this->respond($playlists, 200);
    }
}