<?php

namespace App\Controllers\Playlist;

use App\Services\Playlist\PlaylistFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PlaylistGetController extends ResourceController{

    private PlaylistFinderService $finder;

    public function __construct(){
        $this->finder = new PlaylistFinderService();
    }

    public function find(int $id): ResponseInterface
    {
        $playlist = $this->finder->find($id);
        return $this->response->setJSON($playlist);
    }
}