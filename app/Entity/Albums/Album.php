<?php

namespace App\Entity\Albums;
use App\Dto\Request\Album\AlbumRequest;

use JsonSerializable;

final class Album implements JsonSerializable{

    public function __construct(
        private ?int $id,
        private string $name,
        private string $artist,
        private ?string $portada,
        private ?string $descripcion,
        private ?string $genero,
        private string $creado
    ){}


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

    public function getPortada(): ?string
    {
        return $this->portada;

    }

    public function getDescription(): ?string
    {
        return $this->descripcion;
    }

    public function getGenre(): ?string
    {
        return $this->genero;
    }

    public function getCreado(): string
    {
        return $this->creado;
    }

    public static function convertFromRequest(AlbumRequest $request): Album
    {
        return new Album(
            $request->getId(),
            $request->getName(),
            $request->getArtist(),
            $request->getPortada(),
            $request->getDescription(),
            $request->getGenre(),
            $request->getCreado()
        );
    }


    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'artist' => $this->artist,
            'portada_url' => $this->portada,
            'description' => $this->descripcion,
            'genre' => $this->genero,
            'creado' => $this->creado
        ];
    }
}