<?php

namespace App\Dto\Request\Lyric;


final readonly class LyricRequest{
    public function __construct(
          private ?int $id,
        private int $idTrack,
        private string $letra,
        private string $letraPlana,
        private string $creado

    ){}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTrack(): int
    {
        return $this->idTrack;
    }

    public function getLetra(): string
    {
        return $this->letra;
    }

    public function getLetraPlana(): string
    {
        return $this->letraPlana;
    }

    public function getCreado(): string
    {
        return $this->creado;
    }
    
}