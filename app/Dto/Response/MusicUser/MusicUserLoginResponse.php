<?php

namespace App\Dto\Response\MusicUser;

use JsonSerializable;

final readonly class MusicUserLoginResponse implements JsonSerializable {
    public function __construct(
        public string $token,
        public string $role,
        public int $id,
        public string $logo
    ){}

    public function jsonSerialize(): array
    {
        return [
            'token' => $this->token,
            'role' => $this->role,
            'id' => $this->id,
            'logo' => $this->logo
        ];
    }
}