<?php

namespace App\Services\Favorite;

use App\Converter\Favorite\FavoriteToFavoriteResponseConverter;
use App\Dto\Request\Favorite\FavoriteRequest;
use App\Dto\Response\Favorite\FavoriteResponse;
use App\Entity\Favorite\Favorite;
use App\Models\FavoriteModel;
use RuntimeException;

final class FavoriteCreatorService {

    private FavoriteModel $favoriteModel;
    private FavoriteToFavoriteResponseConverter $converter;

    public function __construct()
    {
        $this->favoriteModel = new FavoriteModel();
        $this->converter = new FavoriteToFavoriteResponseConverter();
    }


    
    public function create(FavoriteRequest $request): FavoriteResponse
{
    $existe = $this->favoriteModel->existsByUserAndSong(
        $request->getIdUser(),
        $request->getTitle(),
        $request->getArtist()
    );

    if ($existe) {
        throw new RuntimeException('La canción ya está en favoritos', 409);
    }

    $favorite = Favorite::convertFromRequest($request);
    $newFavorite = $this->favoriteModel->insert($favorite);
    $favoriteResponse = $this->converter->convert($newFavorite);

    return $favoriteResponse;
}

}