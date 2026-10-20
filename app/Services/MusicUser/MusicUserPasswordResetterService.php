<?php

namespace App\Services\MusicUser;

use App\Dto\Request\MusicUser\MusicUserResetPasswordRequest;
use App\Models\MusicUserModel;
use App\Models\PasswordResetModel;
use Exception;

final class MusicUserPasswordResetterService {
    private MusicUserModel $musicUserModel;
    private PasswordResetModel $passwordResetModel;

    public function __construct() {
        $this->musicUserModel = new MusicUserModel();
        $this->passwordResetModel = new PasswordResetModel();
    }

    public function reset(MusicUserResetPasswordRequest $request): void
    {
        if (strlen($request->getNewPassword()) < 5) {
            throw new Exception('La nueva contraseña debe tener al menos 5 caracteres.', 400);
        }

        $reset = $this->passwordResetModel->findValid(hash('sha256', $request->getToken()));

        if ($reset === null) {
            throw new Exception('El link es inválido o ya venció. Pedí uno nuevo.', 400);
        }

        $musicUser = $this->musicUserModel->find((int) $reset->id_user);

        if ($musicUser === null || $musicUser->isGoogleAccount()) {
            throw new Exception('El link es inválido o ya venció. Pedí uno nuevo.', 400);
        }

        $musicUser->changePassword($request->getNewPassword());

        // Se renueva el token de sesión: cierra las sesiones que hubiera abiertas
        $musicUser->generateToken();
        $this->musicUserModel->update($musicUser);

        // El link se puede usar una sola vez
        $this->passwordResetModel->markUsed((int) $reset->id);
    }
}