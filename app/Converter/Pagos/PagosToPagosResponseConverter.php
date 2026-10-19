<?php

namespace App\Converter\Pagos;

use App\Entity\Pagos\Pagos;
use App\Dto\Response\Pagos\PagosResponse;

final class PagosToPagosResponseConverter
{
    public function convert(Pagos $pagos): PagosResponse
    {
        return new PagosResponse(
             $pagos->getId(),
            $pagos->getIdUser(),
            $pagos->getMonto(),
            $pagos->getFecha(),
            $pagos->getEstado(),
            $pagos->getUltimos(),
            $pagos->getMarca(),
            $pagos->getPlan(),
            $pagos->getPeriodo()
        );
    }
}