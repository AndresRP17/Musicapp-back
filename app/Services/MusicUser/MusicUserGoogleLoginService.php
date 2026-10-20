<?php

namespace App\Services\MusicUser;

use App\Dto\Request\MusicUser\MusicUserGoogleLoginRequest;
use App\Dto\Response\MusicUser\MusicUserLoginResponse;
use App\Entity\MusicUser\MusicUser;
use App\Models\MusicUserModel;
use App\Services\Auth\GoogleTokenVerifierService;

final class MusicUserGoogleLoginService {
    private MusicUserModel $musicUserModel;
    private GoogleTokenVerifierService $verifier;

    public function __construct() {
        $this->musicUserModel = new MusicUserModel();
        $this->verifier = new GoogleTokenVerifierService();
    }

    public function login(MusicUserGoogleLoginRequest $request): MusicUserLoginResponse
    {
        $email = $this->verifier->verify($request->getCredential());

        $musicUser = $this->musicUserModel->findByEmail($email);

        // Si es la primera vez que entra con Google, se crea la cuenta
        if ($musicUser === null) {
            $musicUser = $this->musicUserModel->insert($this->newGoogleUser($email));
        }

        $musicUser->generateToken();
        $this->musicUserModel->update($musicUser);

        return new MusicUserLoginResponse(
            $musicUser->getToken(),
            $musicUser->getRole(),
            $musicUser->getId(),
            $musicUser->getLogo() ?? ''
        );
    }

    private function newGoogleUser(string $email): MusicUser
    {
        // Password aleatoria que nadie conoce: la cuenta solo se usa entrando con Google
        $randomPassword = password_hash(bin2hex(random_bytes(32)), PASSWORD_BCRYPT);

        return new MusicUser(
            null,
            $email,
            $randomPassword,
            'user',
            null,
            null,
            '/yuuta.jpg'
        );
    }
}