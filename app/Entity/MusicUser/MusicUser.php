<?php

namespace App\Entity\MusicUser;

use App\Dto\Request\MusicUser\MusicUserPatchRequest;
use App\Dto\Request\MusicUser\MusicUserRequest;
use Datetime;

final class MusicUser{
    public function __construct(
        private ?int $id,
        private string $email,
        private string $password,
        private string $role,
        private ?string $token,
        private ?DateTime $tokenExpirationDate,
        private ?string $logo,
        private string $authProvider = 'local'
        ){}

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function getTokenExpirationDate(): ?Datetime
    {
        return $this->tokenExpirationDate;
    }

    public function getAuthProvider(): string
    {
        return $this->authProvider;
    }

    public function isGoogleAccount(): bool
    {
        return $this->authProvider === 'google';
    }

    public function changePassword(string $newPassword): void
    {
        $this->password = password_hash($newPassword, PASSWORD_BCRYPT);
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogoPath(string $logo): void
{
    $this->logo = $logo;
}

    public function generateToken(): void
    {
        $this->token = md5($this->email.rand(1000,9999).date("YmdHis"));
        $this->tokenExpirationDate = new Datetime("+1 hours");
    }

    public function update(MusicUserRequest $request): void
    {
        $this->email = $request->getEmail();
        $this->password = $request->getPassword();
        $this->role = $request->getRole();
        $this->logo = $request->getLogo();
    }

    public static function convertFromRequest(MusicUserRequest $request): MusicUser
    {
        return new MusicUser(
            null,
            $request->getEmail(),
            password_hash($request->getPassword(), PASSWORD_BCRYPT),
            $request->getRole(),
            null,
            null,
            $request->getLogo()
        );
    }

    public function patch(MusicUserPatchRequest $request): void
    {
        if($request->hasEmail()){
            $this->email = $request->getEmail();
        }

        if($request->hasPassword()){
            $this->password = $request->getPassword();
        }

        if($request->hasRole()){
            $this->role = $request->getRole();
        }

        if($request->hasLogo()){
            $this->logo = $request->getLogo();
        }
    }


    public function setRole(string $role): void
{
    $this->role = $role; 
}
}