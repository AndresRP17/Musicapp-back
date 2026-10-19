<?php

namespace App\Converter\Track;

use App\Entity\Tracks\Track;

final class PrimitiveToTrackConverter{
    public function convert(array $primitive): Track
    {
        return new Track(
            $primitive['id'],
            $primitive['id_album'],
            $primitive['nombre'],
            (int) $primitive['duracion'],
            $primitive['preview_url'],
            (int) $primitive['orden'],
            $primitive['offset_preview'] !== null ? (float) $primitive['offset_preview'] : null
            );
    }
}