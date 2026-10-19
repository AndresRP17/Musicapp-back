<?php

namespace App\Controllers\Pagos;

use App\Services\Pagos\PagosSearcherService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PagosGetController extends ResourceController
{
    private PagosSearcherService $searcher;

    public function __construct()
    {
        $this->searcher = new PagosSearcherService();
    }

    public function search(): ResponseInterface
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        $userModel = new \App\Models\MusicUserModel();
        $usuario = $userModel->findByToken($token);

        if (!$usuario) {
            return $this->failUnauthorized('No tienes permiso para ver estos pagos.');
        }

        $idUser = $this->request->getGet('id_user');
        $esAdmin = $usuario->getRole() === 'admin';

        if ($idUser && $esAdmin) {
            // Admin pidiendo los pagos de un usuario puntual
            $pagos = $this->searcher->searchByUserId((int)$idUser);
        } elseif ($esAdmin) {
            // ⭐ NUEVO: Admin sin id_user => le devolvemos TODOS los pagos
            // de la plataforma (lo usa el dashboard para los gráficos de ingresos)
            $pagos = $this->searcher->searchAll();
        } else {
            // Usuario común: solo puede ver sus propios pagos
            $pagos = $this->searcher->searchByUserId($usuario->getId());
        }

        return $this->respond($pagos, 200);
    }
}