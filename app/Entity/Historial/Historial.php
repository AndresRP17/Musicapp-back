<?php

namespace App\Entity\Historial;

use JsonSerializable;

final class Historial implements JsonSerializable{
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

    public static function convertFromRequest(HistorialRequest $request): Historial
    {
        return new Historial(
            $request->getId(),
            $request->getIdUser(),
            $request->getIdTrack(),
            $request->getCreado()

        );
    }
}