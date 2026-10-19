<?php

namespace App\Converter\Album;

use App\Dto\Response\Album\AlbumResponse;
use App\Entity\Albums\Album;


final class AlbumToAlbumResponseConverter
{
    public function convert(Album $album): AlbumResponse
    {
        return new AlbumResponse(
            $album->getId(),
            $album->getName(),
            $album->getArtist(),
            $album->getPortada(),
            $album->getDescription(),
            $album->getGenre(),
            $album->getCreado()
        );
    }
}