<?php

namespace App\Controllers\MusicUser;

use App\Dto\Request\MusicUser\MusicUserResetPasswordRequest;
use App\Services\MusicUser\MusicUserPasswordResetterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

final class MusicUserResetPasswordController extends ResourceController {
    private MusicUserPasswordResetterService $service;

    public function __construct() {
        $this->service = new MusicUserPasswordResetterService();
    }

    public function reset(): ResponseInterface
    {
        $this->service->reset($this->getRequest());

        return $this->response->setJSON([
            'message' => 'Contraseña actualizada correctamente.'
        ]);
    }

    public function getRequest(): MusicUserResetPasswordRequest
    {
        $parameters = $this->request->getJSON();

        return new MusicUserResetPasswordRequest(
            $parameters->token ?? '',
            $parameters->newPassword ?? ''
        );
    }
}