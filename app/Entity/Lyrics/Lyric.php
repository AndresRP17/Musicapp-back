<?php

namespace App\Entity\Lyrics;


use App\Dto\Request\Lyric\LyricRequest;
use JsonSerializable;
use Override;

final class Lyric implements JsonSerializable{
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


    public static function convertFromRequest(LyricRequest $request): Lyric
    {
        return new Lyric(
            $request->getId(),
            $request->getIdTrack(),
            $request->getLetra(),
            $request->getLetraPlana(),
            $request->getCreado()
        );
    }


    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'idTrack' => $this->idTrack,
            'letra' => $this->letra,
            'letraPlana' => $this->letraPlana,
            'creado' => $this->creado
        ];
    }
}


