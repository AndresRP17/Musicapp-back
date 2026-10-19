<?php

namespace App\Dto\Response\Album;

final readonly class AlbumResponse {
    public function __construct(
        public ?int $id,
        public string $name,
        public string $artist,
        public string $portada,
        public string $descripcion,
        public string $genero,
        public string $creado
    ){}
}