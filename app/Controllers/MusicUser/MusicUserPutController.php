<?php

namespace App\Controllers\MusicUser;

use App\Dto\Request\MusicUser\MusicUserRequest;
use App\Services\MusicUser\MusicUserUpdaterService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Dto\Request\User\UserRequest;

class MusicUserPutController extends ResourceController
{
    private MusicUserUpdaterService $service;

    public function __construct()
    {
        $this->service = new MusicUserUpdaterService();
    }

    public function put(int $id): ResponseInterface
    {
        $request = $this->getRequest();

        $response = $this->service->update($request, $id);

        return $this->response->setJSON($response);
    }

    private function getRequest(): MusicUserRequest
    {
        $request = $this->request->getJSON();

        return new MusicUserRequest(
            $request->email,
            $request->password,
            $request->role,
            $request->logo
        );
    }

    public function uploadLogo(): ResponseInterface
    {
        $token = $this->request->getPost('token');
        $file = $this->request->getFile('logo');

        if (!$file || !$file->isValid()) {
            return $this->response->setStatusCode(400)->setJSON([
                'error' => 'Archivo inválido o no enviado'
            ]);
        }

        $file->move(FCPATH . 'uploads/logos');
        $logoPath = 'uploads/logos/' . $file->getName();

        $response = $this->service->updateLogo($token, $logoPath);

        return $this->response->setJSON($response);
    }

// INTERFAZ DE ACTUALIZACIÓN DE ROL
public function updateRole()
{
    // 1. Levantamos los datos enviados desde el fetch de React
    $request = $this->request->getJSON();

    // Si por alguna razón el body llegó vacío, evitamos el crash
    if (!$request) {
        return $this->response->setStatusCode(400)->setJSON([
            'status' => 'error',
            'message' => 'No se recibieron datos en la petición'
        ]);
    }

    // 2. Extraemos usando isset para que no explote si no existen
    $token = isset($request->token) ? $request->token : null;
    $role  = isset($request->role) ? $request->role : null;

    // Validamos
    if (!$token || !$role) {
        return $this->response->setStatusCode(400)->setJSON([
            'status' => 'error',
            'message' => 'Faltan datos obligatorios (token o role)'
        ]);
    }

    // 3. Llamamos al Service
    $response = $this->service->updateRole($token, $role);

    // 4. Devolvemos la respuesta tal cual venga del Service
    return $this->response->setJSON($response);
}
}