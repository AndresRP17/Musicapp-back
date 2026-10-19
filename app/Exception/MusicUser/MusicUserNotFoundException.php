<?php

namespace App\Exception\MusicUser;

use Exception;

class MusicUserNotFoundException extends Exception {

        public function __construct(int $id) {
            parent::__construct("No se encontro el usuario con id: $id", 404);
        }
}