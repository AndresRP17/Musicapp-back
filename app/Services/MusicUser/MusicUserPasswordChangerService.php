<?php

namespace App\Services\MusicUser;

use App\Dto\Request\MusicUser\MusicUserChangePasswordRequest;
use App\Models\MusicUserModel;
use Exception;

final class MusicUserPasswordChangerService {
    private MusicUserModel $musicUserModel;

    public function __construct() {
        $this->musicUserModel = new MusicUserModel();
    }

    public function change(MusicUserChangePasswordRequest $request): void
    {
        $musicUser = $this->musicUserModel->findByToken($request->getToken());

        if ($musicUser === null) {
            throw new Exception('Sesión inválida o expirada. Volvé a iniciar sesión.', 401);
        }

        if ($musicUser->isGoogleAccount()) {
            throw new Exception('Tu cuenta se creó con Google, no tiene contraseña para cambiar.', 403);
        }

        if (!$musicUser->verifyPassword($request->getCurrentPassword())) {
            throw new Exception('La contraseña actual es incorrecta.', 400);
        }

        if (strlen($request->getNewPassword()) < 5) {
            throw new Exception('La nueva contraseña debe tener al menos 5 caracteres.', 400);
        }

        if ($request->getCurrentPassword() === $request->getNewPassword()) {
            throw new Exception('La nueva contraseña tiene que ser distinta a la actual.', 400);
        }

        $musicUser->changePassword($request->getNewPassword());

        $this->musicUserModel->update($musicUser);
    }
}