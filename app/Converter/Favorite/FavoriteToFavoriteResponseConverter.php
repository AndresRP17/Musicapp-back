<?php


namespace App\Converter\Favorite;

use App\Entity\Favorite\Favorite;
use App\Dto\Response\Favorite\FavoriteResponse;

final class FavoriteToFavoriteResponseConverter
{
    public function convert(Favorite $favorite): FavoriteResponse
    {
        return new FavoriteResponse(
            $favorite->getId(),
            $favorite->getIdUser(),
            $favorite->getTitle(),
            $favorite->getArtist(),
            $favorite->getAlbum(),
            $favorite->getDuration(),
            $favorite->getGenre()
        );
    }
}