<?php

namespace App\Controllers\Pagos;

use App\Dto\Request\Pagos\PagosRequest;
use App\Services\Pagos\PagosCreatorService;
use App\Models\MusicUserModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PagosPostController extends ResourceController {

    private PagosCreatorService $pagosCreatorService;

    public function __construct()
    {
        $this->pagosCreatorService = new PagosCreatorService();
    }

    public function create(): ResponseInterface
    {
        // 1. Obtener el token del Header
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        // 2. Validar el token
        $userModel = new MusicUserModel();
        $usuario = $userModel->findByToken($token);

        if (!$usuario) {
            return $this->failUnauthorized('Token inválido o expirado.');
        }

        // 3. Capturar los datos del JSON
        $parameters = $this->request->getJSON();

        // 4. Crear el Request inyectando el ID del usuario autenticado
        $pagosRequest = new PagosRequest(
            (int)$usuario->getId(),
            $parameters->monto,
            $parameters->ultimos,
            $parameters->marca,
            $parameters->plan,
            $parameters->periodo
        );

        try {
            $pagosResponse = $this->pagosCreatorService->create($pagosRequest);
            return $this->response->setJSON($pagosResponse);
        } catch (\RuntimeException $e) {
            return $this->response
                ->setStatusCode($e->getCode())
                ->setJSON(['error' => $e->getMessage()]);
        }
    }
}