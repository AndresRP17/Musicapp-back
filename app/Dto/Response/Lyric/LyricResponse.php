<?php

namespace App\Dto\Response\Lyric;

final readonly class LyricResponse{
    public function __construct(
        public ?int $id,
        public int $idTrack,
        public string $letra,
        public string $letraPlana,
        public string $creado

    ){}

}