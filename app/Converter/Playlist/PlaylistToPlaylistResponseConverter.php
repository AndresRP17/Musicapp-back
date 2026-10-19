<?php

namespace App\Converter\Playlist;

use App\Entity\Playlist\Playlist;
use App\Dto\Response\Playlist\PlaylistResponse;

final class PlaylistToPlaylistResponseConverter {
    public function converter (Playlist $playlist): PlaylistResponse
    {
        return new PlaylistResponse(
            $playlist->getId(),
            $playlist->getIdUser(),
            $playlist->getName()
        );
    }
}