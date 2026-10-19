<?php

namespace App\Dto\Request\Album;


final readonly class AlbumRequest{
    public function __construct(
        private int $id,
        private string $name,
        private string $artist,
        private string $portada,
        private string $description,
        private string $genero,
        private string $creado
    )
    {}

    public function getId(): ?int{
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getArtist(): string
    {
        return $this->artist;
    }

    public function getPortada(): string
    {
        return $this->portada;

    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getGenre(): ?string
    {
        return $this->genero;
    }

    public function getCreado(): string
    {
        return $this->creado;
    }

}