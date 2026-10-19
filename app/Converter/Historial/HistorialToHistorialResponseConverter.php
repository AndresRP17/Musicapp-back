<?php

namespace App\Converter\Historial;

use App\Dto\Response\Historial\HistorialResponse;
use App\Entity\Historial\Historial;

final class HistorialToHistorialResponseConverter{
    public function convert(Historial $historial): HistorialResponse
    {
        return new HistorialResponse(
            $historial->getId(),
            $historial->getIdUser(),
            $historial->getIdTrack(),
            $historial->getCreado()
        );
    }
}