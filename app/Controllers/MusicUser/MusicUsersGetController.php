<?php

namespace App\Controllers\MusicUser;

use App\Services\MusicUser\MusicUsersSearcherService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

final class MusicUsersGetController extends ResourceController {
    private MusicUsersSearcherService $musicUsersSearcherService;

    public function __construct()
    {
        $this->musicUsersSearcherService = new MusicUsersSearcherService();
    }

    public function search(): ResponseInterface
    {
        $musicUser = $this->musicUsersSearcherService->search();

        return $this->respond($musicUser);
    }
}