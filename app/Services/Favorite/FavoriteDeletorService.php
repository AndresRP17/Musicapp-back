<?php

namespace App\Services\Favorite;

use App\Models\FavoriteModel;

final  class FavoriteDeletorService{

    private FavoriteModel $favoriteModel;
    private FavoriteFinderService $favoriteFinderService;

    public function __construct(){

        $this->favoriteModel = new FavoriteModel();
        $this->favoriteFinderService = new FavoriteFinderService();
    }
       
    public function delete(int $id): void 
    {
        $favorite = $this->favoriteFinderService->find($id);

        $this->favoriteModel->delete($favorite->getId());
    } 
}
