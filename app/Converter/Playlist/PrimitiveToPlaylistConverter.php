<?php

namespace App\Converter\Playlist;

use App\Entity\Playlist\Playlist;

final class PrimitiveToPlaylistConverter {

    public function converter(object $primitive): Playlist
    {
        return new Playlist(
            $primitive->id,
            $primitive->id_user,
            $primitive->name
        );
    }
}