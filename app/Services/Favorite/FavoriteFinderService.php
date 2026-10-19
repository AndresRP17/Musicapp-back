<?php

namespace App\Services\Favorite;

use App\Exception\Favorite\FavoriteNotFoundException;
use App\Models\FavoriteModel;

final class FavoriteFinderService {

    private FavoriteModel $favoriteModel;

    public function __construct() {
        $this->favoriteModel = new FavoriteModel();
    }

    public function find(int $id): object
    {
        $favorite = $this->favoriteModel->find($id);

        if (empty($favorite)) {
            throw new FavoriteNotFoundException($id);
        } 
        return $favorite;
    }
}