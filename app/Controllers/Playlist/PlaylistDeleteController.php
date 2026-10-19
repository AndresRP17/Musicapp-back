<?php

namespace App\Controllers\Playlist;

use App\Services\Playlist\PlaylistDeletorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PlaylistDeleteController extends ResourceController{
    private PlaylistDeletorService $deletor;

    public function __construct(){
        $this->deletor = new PlaylistDeletorService();

    }

    public function do($id): Responseinterface
    {
        $id = (int) $id;

        $this->deletor->delete($id);

        return $this->response->setJSON([
            "id" => $id 
        ]);
    }
}