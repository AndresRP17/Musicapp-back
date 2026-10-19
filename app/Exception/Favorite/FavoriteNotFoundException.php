<?php

namespace App\Exception\Favorite;

use Exception;

class FavoriteNotFoundException extends Exception {

        public function __construct(int $id) {
            parent::__construct("No se encontro el favorite con id: $id", 404);
        }
}