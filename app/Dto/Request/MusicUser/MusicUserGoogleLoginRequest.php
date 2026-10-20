<?php

namespace App\Dto\Request\MusicUser;

final readonly class MusicUserGoogleLoginRequest {
    public function __construct(
        private string $credential,
    ){}

    public function getCredential(): string
    {
        return $this->credential;
    }
}