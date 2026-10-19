<?php

namespace App\Controllers\MusicUser;

use App\Services\MusicUser\MusicUserFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MusicUserGetController extends ResourceController {

    private MusicUserFinderService $musicUserFinderSerivce;

    public function __construct() {
        $this->musicUserFinderSerivce = new MusicUserFinderService();

    }

    public function find(int $id): ResponseInterface
    {
        $musicUser = $this->musicUserFinderSerivce->findResponse($id);
        return $this->response->setJSON($musicUser);
    }

}