<?php 

namespace App\Dto\Response\Favorite;

final readonly class FavoriteResponse {
    public function __construct(
        
        public int $id,
        public int $id_user,
        public string $title,
        public string $artist,
        public string $album,
        public int $duration,
        public string $genre
    ) {}
}