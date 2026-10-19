<?php

namespace App\Dto\Request\MusicUser;


final readonly class MusicUserRequest {
    public function __construct(
        private string $email,
        private string $password,
        private string $role,
        private string $logo
    ){}

 
    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

}