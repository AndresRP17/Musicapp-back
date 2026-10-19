<?php 

namespace App\Dto\Response\Playlist;

final readonly class PlaylistResponse {
    public function __construct(
        
        public int $id,
        public int $id_user,
        public string $name
    ) {}
}