<?php 

namespace App\Exception\MusicUser;

use Exception;

class MusicUserNotFoundByEmailException extends Exception {
    public function __construct(string $email) {
        parent::__construct("No se encontro el user con email: $email", 404);
    }
}