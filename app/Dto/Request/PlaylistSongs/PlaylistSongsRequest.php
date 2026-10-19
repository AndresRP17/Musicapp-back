<?php

namespace App\Dto\Request\PlaylistSongs;

final readonly class PlaylistSongsRequest{
    public function __construct(
    private ?int $id,
        private int $id_playlist,
        private string $title,
        private string $artist,
        private string $album,
        private int $duration,
        private string $genre
    ){}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdPlaylist(): int
    {
        return $this->id_playlist;
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