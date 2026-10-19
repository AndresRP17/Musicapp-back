<?php

namespace App\Converter\Favorite;


use App\Entity\Favorite\Favorite;


final class PrimitiveToFavoriteConverter {
    public function convert(object $primitive): Favorite
    {
        return new Favorite(
            $primitive->id,
            $primitive->id_user,
            $primitive->title,
            $primitive->artist,
            $primitive->album,
            $primitive->duration,
            $primitive->genre
        );
    }
}