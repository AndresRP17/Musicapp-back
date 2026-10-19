<?php

namespace App\Services\Auth;

use App\Models\MusicUserModel;

final class TokenValidatorService {
    private MusicUserModel $musicUserModel;

    public function __construct() {
        $this->musicUserModel = new MusicUserModel();
    }

    public function validate(string $token): bool
    {
        $musicUser = $this->musicUserModel->findByToken($token);

        return !empty($musicUser);
    }
}