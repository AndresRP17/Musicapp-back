<?php

namespace App\Converter\PlaylistSongs;

use App\Entity\PlaylistSongs\PlaylistSongs;
use App\Dto\Response\PlaylistSongs\PlaylistSongsResponse;


final class PlaylistSongsToPlaylistSongsResponseConverter {
    public function converter (PlaylistSongs $playlistSongs): PlaylistSongsResponse 
    {
        return new PlaylistSongsResponse(
            $playlistSongs->getId(),
            $playlistSongs->getIdPlaylist(),
            $playlistSongs->getTitle(),
            $playlistSongs->getArtist(),
            $playlistSongs->getAlbum(),
            $playlistSongs->getDuration(),
            $playlistSongs->getGenre()
        );
    }
}