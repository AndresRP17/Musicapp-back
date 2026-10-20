<?php

namespace App\Controllers\MusicUser;

use App\Dto\Request\MusicUser\MusicUserChangePasswordRequest;
use App\Services\MusicUser\MusicUserPasswordChangerService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

final class MusicUserChangePasswordController extends ResourceController {
    private MusicUserPasswordChangerService $service;

    public function __construct() {
        $this->service = new MusicUserPasswordChangerService();
    }

    public function change(): ResponseInterface
    {
        $this->service->change($this->getRequest());

        return $this->response->setJSON([
            'message' => 'Contraseña actualizada correctamente.'
        ]);
    }

    public function getRequest(): MusicUserChangePasswordRequest
    {
        $parameters = $this->request->getJSON();

        return new MusicUserChangePasswordRequest(
            $parameters->token ?? '',
            $parameters->currentPassword ?? '',
            $parameters->newPassword ?? ''
        );
    }
}