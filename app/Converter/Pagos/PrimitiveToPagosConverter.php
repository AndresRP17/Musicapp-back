<?php

namespace App\Converter\Pagos;


use App\Entity\Pagos\Pagos;


final class PrimitiveToPagosConverter{
    public function convert(object $primitive): Pagos
    {
        return new Pagos(
            $primitive->id,
            $primitive->id_user,
             $primitive->monto,
            $primitive->fecha,
            $primitive->estado,
            $primitive->ultimos,
            $primitive->marca,
            $primitive->plan,
            $primitive->periodo
        );
    }
}