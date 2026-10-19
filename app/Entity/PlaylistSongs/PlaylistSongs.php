<?php

namespace App\Entity\PlaylistSongs;
use App\Dto\Request\PlaylistSongs\PlaylistSongsRequest;
use JsonSerializable;

final class PlaylistSongs implements JsonSerializable {  
    public function __construct(
        private ?int $id,
        private int $id_playlist,
        private string $title,
        private string $artist,
        private string $album,
        private int $duration,
        private string $genre
    ){}

    public function getId(): ?int { return $this->id; }
    public function getIdPlaylist(): int { return $this->id_playlist; }
    public function getTitle(): string { return $this->title; }
    public function getArtist(): string { return $this->artist; }
    public function getAlbum(): string { return $this->album; }
    public function getDuration(): int { return $this->duration; }
    public function getGenre(): string { return $this->genre; }

    public static function convertFromRequest(PlaylistSongsRequest $request): PlaylistSongs
    {
        return new PlaylistSongs(
            null,
            $request->getIdPlaylist(),
            $request->getTitle(),
            $request->getArtist(),
            $request->getAlbum(),
            $request->getDuration(),
            $request->getGenre(),
        );
    }

    public function jsonSerialize(): array  
    {
        return [
            'id'          => $this->id,
            'id_playlist' => $this->id_playlist,
            'title'       => $this->title,
            'artist'      => $this->artist,
            'album'       => $this->album,
            'duration'    => $this->duration,
            'genre'       => $this->genre,
        ];
    }
}