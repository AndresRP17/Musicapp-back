<?php

namespace App\Converter\Track;

use App\Dto\Response\Track\TrackResponse;
use App\Entity\Tracks\Track;

final class TrackToTrackResponseConverter{
    public function convert(Track $track): TrackResponse
    {
        return new TrackResponse(
            $track->getId(),
            $track->getIdAlbum(),
            $track->getName(),
            $track->getDuration(),
            $track->getUrl(),
            $track->getOrden(),
        );
    }
}