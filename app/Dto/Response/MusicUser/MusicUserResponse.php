<?php

namespace App\Dto\Response\MusicUser;

final readonly class MusicUserResponse{
    public function __construct(
         public ?int $id,
        public string $email,
        public string $password,
        public string $role,
        public ?string $logo = null
    ){}

    
}