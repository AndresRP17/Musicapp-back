<?php


namespace App\Converter\PlaylistSongs;

use App\Entity\PlaylistSongs\PlaylistSongs;


final class PrimitiveToPlaylistSongsConverter{

    public function converter(object $primitive): PlaylistSongs
    {
        return new PlaylistSongs(
            $primitive->id,
            $primitive->id_playlist,
            $primitive->title,
            $primitive->artist,
            $primitive->album,
            $primitive->duration,
            $primitive->genre
        );
    }
}