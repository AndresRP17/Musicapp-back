<?php

namespace App\Dto\Request\MusicUser;

final readonly class MusicUserChangePasswordRequest {
    public function __construct(
        private string $token,
        private string $currentPassword,
        private string $newPassword,
    ){}

    public function getToken(): string
    {
        return $this->token;
    }

    public function getCurrentPassword(): string
    {
        return $this->currentPassword;
    }

    public function getNewPassword(): string
    {
        return $this->newPassword;
    }
}