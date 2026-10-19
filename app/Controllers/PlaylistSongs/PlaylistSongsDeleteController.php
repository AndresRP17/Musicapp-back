<?php

namespace App\Controllers\PlaylistSongs;

use App\Services\Playlist\PlaylistDeletorService;
use App\Services\PlaylistSongs\PlaylistSongsDeletorService;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;

class PlaylistSongsDeleteController extends ResourceController{

    private PlaylistSongsDeletorService $deletor;

    public function __construct(){
        $this->deletor = new PlaylistSongsDeletorService();
    }

    public function do($id): ResponseInterface
    {
        $id = (int) $id;

        $this->deletor->delete($id);

        return $this->response->setJSON([
            "id" => $id 
        ]);
    }

}