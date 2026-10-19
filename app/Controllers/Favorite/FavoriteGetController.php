<?php

namespace App\Controllers\Favorite;

use App\Services\Favorite\FavoriteFinderService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class FavoriteGetController extends ResourceController {

    private FavoriteFinderService $favoriteFinderService;

    public function __construct() {

        $this->favoriteFinderService = new FavoriteFinderService();
    }

    public function find(int $id): ResponseInterface
    {
        $favorite = $this->favoriteFinderService->find($id);
        return $this->response->setJSON($favorite);
    }
}