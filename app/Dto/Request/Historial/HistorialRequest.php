<?php

namespace App\Dto\Request\Historial;

final readonly class HistorialRequest{

public function __construct(
        private ?int $id,
        private int $idUser,
        private int $idTrack,
        private string $creado
    ){}

    public function getId(): ?int
    {
        return $this->id;
    }

     public function getIdUser(): int
    {
        return $this->idUser;
    }

     public function getIdTrack(): int
    {
        return $this->idTrack;
    }

     public function getCreado(): string
    {
        return $this->creado;
    }

}