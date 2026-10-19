<?php

namespace App\Controllers\MusicUser;

use App\Dto\Request\MusicUser\MusicUserPatchRequest;
use App\Services\MusicUser\MusicUserUpdaterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MusicUserPatchController extends ResourceController{
    private MusicUserUpdaterService $service;

    public function __construct()
    {
        $this->service = new MusicUserUpdaterService();
    }

    public function patch(int $id): ResponseInterface
    {
        $request = $this->getRequest();

        $response = $this->service->patch($request, $id);

        return $this->response->setJSON($response);
    }

    public function getRequest(): MusicUserPatchRequest
    {
        // Pasamos true a getJSON para que nos devuelva un array asociativo
        $rawInput = $this->request->getJSON(true) ?? [];

        // Usamos el método estático que creamos en el paso anterior para armar el DTO
        return MusicUserPatchRequest::fromArray($rawInput);
    }
}