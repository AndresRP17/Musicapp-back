<?php

namespace App\Controllers\MusicUser;

use App\Dto\Request\MusicUser\MusicUserForgotPasswordRequest;
use App\Services\MusicUser\MusicUserPasswordResetRequesterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

final class MusicUserForgotPasswordController extends ResourceController {
    private MusicUserPasswordResetRequesterService $service;

    public function __construct() {
        $this->service = new MusicUserPasswordResetRequesterService();
    }

    public function forgot(): ResponseInterface
    {
        $this->service->request($this->getRequest());

        return $this->response->setJSON([
            'message' => 'Si el mail está registrado, te enviamos un link para elegir una nueva contraseña.'
        ]);
    }

    public function getRequest(): MusicUserForgotPasswordRequest
    {
        $parameters = $this->request->getJSON();

        return new MusicUserForgotPasswordRequest(
            $parameters->email ?? ''
        );
    }
}