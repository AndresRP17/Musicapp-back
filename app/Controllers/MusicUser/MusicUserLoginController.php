<?php

namespace App\Controllers\MusicUser;

use App\Dto\Request\MusicUser\MusicUserLoginRequest;
use App\Services\MusicUser\MusicUserLoginService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;


final class MusicUserLoginController extends ResourceController{
    private MusicUserLoginService $service;

    public function __construct() {
        $this->service = new MusicUserLoginService();
    }

    public function login(): ResponseInterface
    {
        $request = $this->getRequest();

        $response = $this->service->login($request);

        return $this->response->setJSON($response);
    }

    public function getRequest(): MusicUserLoginRequest
    {
        $clienteRequest = $this->request->getJSON();

        return new MusicUserLoginRequest(
            $clienteRequest->email,
            $clienteRequest->password,
        );
    }
}