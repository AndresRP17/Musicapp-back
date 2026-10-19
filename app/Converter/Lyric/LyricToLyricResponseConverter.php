<?php

namespace App\Converter\Lyric;

use App\Dto\Response\Lyric\LyricResponse;
use App\Entity\Lyrics\Lyric;

final class LyricToLyricResponseConverter
{
    public function convert(Lyric $lyric): LyricResponse
    {
        return new LyricResponse(
            $lyric->getId(),
            $lyric->getIdTrack(),
            $lyric->getLetra(),
            $lyric->getLetraPlana(),
            $lyric->getCreado()
        );
    }
}