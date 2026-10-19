<?php


namespace App\Dto\Response\PlaylistSongs;


final readonly class PlaylistSongsResponse {
    public function __construct(
        public int $id,
        public int $id_playlist,
        public string $title,
        public string $artist,
        public string $album,
        public int $duration,
        public string $genre
    ){}
}