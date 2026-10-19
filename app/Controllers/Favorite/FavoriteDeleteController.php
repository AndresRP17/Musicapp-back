<?php

namespace App\Controllers\Favorite;

use App\Services\Favorite\FavoriteDeletorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class FavoriteDeleteController extends ResourceController{

    private FavoriteDeletorService $favoriteDeletetorService;

    public function __construct(){
        $this->favoriteDeletetorService = new FavoriteDeletorService();

    }

    public function do($id): ResponseInterface
    {
            $id = (int) $id;

        $this->favoriteDeletetorService->delete($id);

        return $this->response->setJSON([
            "id" => $id
        ]);
    }
}