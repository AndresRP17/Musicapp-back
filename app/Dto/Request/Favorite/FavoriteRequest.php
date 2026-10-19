<?php

namespace App\Dto\Request\Favorite;

final readonly class FavoriteRequest{
    public function __construct(
        private int $idUser,
        private string $title,
        private string $artist,
        private string $album,
        private int $duration,
        private string $genre
        
    ){}

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getArtist(): string
    {
        return $this->artist;
    }

    public function getAlbum(): string
    {
        return $this->album;
    }

    public function getDuration(): int
    {
        return $this->duration;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }
}

