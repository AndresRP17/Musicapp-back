<?php

namespace App\Converter\Lyric;

use App\Entity\Lyrics\Lyric;

final class PrimitiveToLyricConverter{
    public function convert(array $primitive): Lyric
    {
        return new Lyric(
            $primitive['id'],
            $primitive['id_track'],
            $primitive['letra_sincronizada'],
            $primitive['letra_plana'],
            $primitive['creado_en'],
        );
    }
}