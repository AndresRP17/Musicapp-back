<?php

namespace App\Controllers\PlaylistSongs;

use App\Services\PlaylistSongs\PlaylistSongsSearcherService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PlaylistsSongsGetController extends ResourceController
{
    private PlaylistSongsSearcherService $searcher;

    public function __construct()
    {
        $this->searcher = new PlaylistSongsSearcherService();
    }

    public function search(int $id_playlist): ResponseInterface
    {
        $songs = $this->searcher->searchByPlaylistId($id_playlist);

        return $this->respond($songs, 200);
    }
}