<?php

namespace App\Controllers\MusicUser;

use App\Services\MusicUser\MusicUserDeletorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MusicUserDeleteController extends ResourceController{
    private MusicUserDeletorService $musicUserDeletorService;


    public function __construct(){
        $this->musicUserDeletorService = new MusicUserDeletorService();
    }

    public function do(int $id): ResponseInterface
    {
        $this->musicUserDeletorService->delete($id);

        return $this->response->setJSON([
            "id" => $id
        ]);
            
    }
}