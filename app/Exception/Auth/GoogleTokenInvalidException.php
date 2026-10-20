<?php

namespace App\Exception\Auth;

use Exception;

class GoogleTokenInvalidException extends Exception {
    public function __construct(string $message = 'Token de Google invalido o expirado', int $code = 401) {
        parent::__construct($message, $code);
    }
}