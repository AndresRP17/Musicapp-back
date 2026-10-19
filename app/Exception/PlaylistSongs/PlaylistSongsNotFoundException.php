<?php

namespace App\Exception\PlaylistSongs;

use Exception;

class PlaylistSongsNotFoundException extends Exception {

        public function __construct(int $id) {
            parent::__construct("No se encontro la playlist con id: $id", 404);
        }
}