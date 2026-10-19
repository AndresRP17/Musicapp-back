<?php

namespace App\Exception\Pagos;

use Exception;

class PagosNotFoundException extends Exception {

        public function __construct(int $id) {
            parent::__construct("No se encontro el pagos con id: $id", 404);
        }
}