<?php

namespace App\Dto\Request\Track;

final readonly class TrackRequest{
    public function __construct(

        private ?int $id,
        private int $idAlbum,
        private string $name,
        private string $duration,
        private string $url,
        private int $orden

    ){}

    public function getId(): ?int{
        return $this->id;
    }

    public function getIdAlbum(): int
    {
        return $this->idAlbum;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDuration(): int{
        return $this->duration;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getOrden(): int
    {
        return $this->orden;
    }
   
}