<?php 

namespace App\Exception\MusicUser;

use Exception;

class MusicUserWrongPasswordException extends Exception {
    public function __construct() {
        parent::__construct("Contraseña incorrecta", 500);
    }
}