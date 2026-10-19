<?php

namespace App\Dto\Response\Pagos;


final readonly class PagosResponse{
    public function __construct(

        public ?int $id,
        public int $idUser,
        public string $monto,
        public string $fecha,
        public string $estado,
        public string $ultimos,
        public string $marca,
        public string $plan,
        public string $periodo
    )
    {}
}