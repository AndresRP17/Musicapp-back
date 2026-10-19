<?php

namespace App\Exception\Playlist;

use Exception;

class PlaylistNotFoundException extends Exception {

        public function __construct(int $id) {
            parent::__construct("No se encontro la playlist con id: $id", 404);
        }
}