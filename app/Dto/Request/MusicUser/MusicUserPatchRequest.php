<?php

namespace App\Dto\Request\MusicUser;

final readonly class MusicUserPatchRequest {
    public function __construct(
        private ?string $email = null,
        private ?string $password = null,
        private ?string $role = null,
        private ?string $logo = null,
        private array $presentFields = []
    ){}

    public static function fromArray(array $input): self
    {
        $presentFields = array_keys($input);

        return new self(
            $input['email'] ?? null,
            array_key_exists('password', $input) ? password_hash($input['password'], PASSWORD_BCRYPT) : null,
            $input['role'] ?? null,
            $presentFields
        );
    }

    public function hasEmail(): bool { return in_array('email', $this->presentFields); }
    public function getEmail(): ?string { return $this->email; }

    public function hasPassword(): bool { return in_array('password', $this->presentFields); }
    public function getPassword(): ?string { return $this->password; }

    public function hasRole(): bool { return in_array('role', $this->presentFields); }
    public function getRole(): ?string { return $this->role; }

     public function hasLogo(): bool { return in_array('logo', $this->presentFields); }
    public function getLogo(): ?string { return $this->logo; }
}