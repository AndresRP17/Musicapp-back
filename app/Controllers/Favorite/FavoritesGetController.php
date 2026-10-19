<?php

namespace App\Controllers\Favorite;

use App\Services\Favorite\FavoriteSearcherService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

final class FavoritesGetController extends ResourceController {

    private FavoriteSearcherService $favoriteSearcherService;

    public function __construct() {
        $this->favoriteSearcherService = new FavoriteSearcherService();
    }

    public function search(): ResponseInterface
    {
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

        $userModel = new \App\Models\MusicUserModel();
        $usuario = $userModel->findByToken($token);

        if (!$usuario) {
            return $this->failUnauthorized('No tienes permiso para ver estos favoritos.');
        }

        $idUser = $this->request->getGet('id_user');

        if ($idUser && $usuario->getRole() === 'admin') {
            $favorites = $this->favoriteSearcherService->searchByUserId((int)$idUser);
        } else {
            $favorites = $this->favoriteSearcherService->searchByUserId($usuario->getId());
        }

        return $this->respond($favorites, 200);
    }
}