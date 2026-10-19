<?php

namespace App\Converter\Historial;

use App\Entity\Historial\Historial;

final class PrimitiveToHistorialConverter{
    public function convert(array $primitive): Historial
    {
        return new Historial(
            $primitive['id'],
            $primitive['id_user'],
            $primitive['id_track'],
            $primitive['reproducido_en']
        );
    }
}