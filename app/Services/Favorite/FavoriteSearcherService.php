<?php

namespace App\Services\Favorite;

use App\Models\FavoriteModel;

final class FavoriteSearcherService {

    private FavoriteModel $favoriteModel;

    public function __construct(){
        $this->favoriteModel = new FavoriteModel();
    }

    public function searchByUserId(int $id_user): array
    {
        return $this->favoriteModel->searchByUserId($id_user);
    }
}