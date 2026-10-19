<?php

namespace App\Entity\Pagos;

final class Pagos implements \JsonSerializable
{
    public function __construct(
        private ?int $id,
        private int $idUser,
        private string $monto,
        private string $fecha,
        private string $estado,
        private string $ultimos,
        private string $marca,
        private string $plan,
        private string $periodo

    )
    {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): int
    {
        return $this->idUser;
    }


    public function getMonto(): string
    {
        return $this->monto;
    }


    public function getFecha(): string
    {
        return $this->fecha;
    }


    public function getEstado(): string
    {
        return $this->estado;
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

    public function jsonSerialize(): array
    {
        return [
            'id'      => $this->id,
            'id_user' => $this->idUser,
            'monto'   => $this->monto,
            'fecha'   => $this->fecha,
            'estado'  => $this->estado,
            'ultimos' => $this->ultimos,
            'marca'   => $this->marca,
            'plan'    => $this->plan,
            'periodo' => $this->periodo,
        ];
    }
}
