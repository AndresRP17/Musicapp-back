<?php

namespace App\Dto\Request\Pagos;

final readonly class PagosRequest{
    public function __construct(
       
        private int $idUser,
        private string $monto,
        private string $ultimos,
        private string $marca,
        private string $plan,
        private string $periodo   

    )
    {}

    public function getIdUser(): int
    {
        return $this->idUser;
    }


    public function getMonto(): string
    {
        return $this->monto;
    }


    public function getUltimos(): string
    {
        return $this->ultimos;
    }


    public function getMarca(): string
    {
        return $this->marca;
    }

    public function getPlan(): string
    {
        return $this->plan;

    }

    public function getPeriodo(): string
    {
        return $this->periodo;
    }
}