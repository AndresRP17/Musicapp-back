<?php

namespace App\Dto\Request\MusicUser;

final readonly class MusicUserResetPasswordRequest {
    public function __construct(
        private string $token,
        private string $newPassword,
    ){}

    public function getToken(): string
    {
        return $this->token;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}