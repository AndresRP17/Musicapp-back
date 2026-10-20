<?php

namespace App\Dto\Request\MusicUser;

final readonly class MusicUserForgotPasswordRequest {
    public function __construct(
        private string $email,
    ){}

    public function getEmail(): string
    {
        return $this->email;
    }
}