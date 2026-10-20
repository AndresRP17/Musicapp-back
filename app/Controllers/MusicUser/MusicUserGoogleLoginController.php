<?php

namespace App\Controllers\MusicUser;

use App\Dto\Request\MusicUser\MusicUserGoogleLoginRequest;
use App\Services\MusicUser\MusicUserGoogleLoginService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

final class MusicUserGoogleLoginController extends ResourceController {
    private MusicUserGoogleLoginService $service;

    public function __construct() {
        $this->service = new MusicUserGoogleLoginService();
    }

    public function login(): ResponseInterface
    {
        $response = $this->service->login($this->getRequest());

        return $this->response->setJSON($response);
    }

    public function getRequest(): MusicUserGoogleLoginRequest
    {
        $parameters = $this->request->getJSON();

        return new MusicUserGoogleLoginRequest(
            $parameters->credential ?? ''
        );
    }
}