<?php

namespace App\Services\Auth;

use App\Models\UserModel;

final class TokenValidatorService {
    private UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function validate(string $token): bool
    {
        $user = $this->userModel->findByToken($token);

        return !empty($user);
    }
}