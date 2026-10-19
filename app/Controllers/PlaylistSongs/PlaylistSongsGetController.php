<?php

namespace App\Controllers\PlaylistSongs;

use App\Services\PlaylistSongs\PlaylistSongsFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PlaylistSongsGetController extends ResourceController {

    private PlaylistSongsFinderService $finder;

    public function __construct(){
        $this->finder = new PlaylistSongsFinderService();
    }

    public function find(int $id): ResponseInterface
    {
        $playlistSongs = $this->finder->find($id);
        return $this->response->setJSON($playlistSongs);
    }
}