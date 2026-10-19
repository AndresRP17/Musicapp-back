<?php

namespace App\Controllers\MusicUser;

use App\Services\MusicUser\MusicUserProjectionService;
use App\Exception\MusicUser\MusicUserNotFoundException;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

final class MusicUserProjectionController extends ResourceController {

    private MusicUserProjectionService $service;

    public function __construct() {
        $this->service = new MusicUserProjectionService();
    }

    public function find(int $id): ResponseInterface
    {
        try {
            $projection = $this->service->findProjected($id);
            return $this->response->setJSON($projection);
        } catch (MusicUserNotFoundException $e) {
            return $this->response->setStatusCode(404)->setJSON([
                'error' => $e->getMessage()
            ]);
        }
    }
}