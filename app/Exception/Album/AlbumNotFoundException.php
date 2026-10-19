<?php

namespace App\Exception\Album;


use Exception;

class AlbumNotFoundException extends Exception {

    public function __construct(int $id) {
        parent:: __construct("No se encontro el album con el id: $id", 404);
    }
}
