<?php

namespace App\Services\MusicUser;

use App\Dto\Request\MusicUser\MusicUserForgotPasswordRequest;
use App\Models\MusicUserModel;
use App\Models\PasswordResetModel;
use App\Services\Auth\PasswordResetNotifierService;
use DateTime;

final class MusicUserPasswordResetRequesterService {
    private MusicUserModel $musicUserModel;
    private PasswordResetModel $passwordResetModel;
    private PasswordResetNotifierService $notifier;

    public function __construct() {
        $this->musicUserModel = new MusicUserModel();
        $this->passwordResetModel = new PasswordResetModel();
        $this->notifier = new PasswordResetNotifierService();
    }

    public function request(MusicUserForgotPasswordRequest $request): void
    {
        $email = strtolower(trim($request->getEmail()));

        $musicUser = $this->musicUserModel->findByEmail($email);

        // La respuesta es siempre la misma exista o no el mail (no se revelan cuentas).
        // Las cuentas de Google no tienen contraseña, así que tampoco se les manda nada.
        if ($musicUser === null || $musicUser->isGoogleAccount()) {
            return;
        }

        // Token aleatorio: al usuario le llega el original, en la base queda solo el hash
        $token = bin2hex(random_bytes(32));
        $expiresAt = (new DateTime('+1 hour'))->format('Y-m-d H:i:s');

        // Un solo link activo por usuario
        $this->passwordResetModel->deleteByUser($musicUser->getId());
        $this->passwordResetModel->insert($musicUser->getId(), hash('sha256', $token), $expiresAt);

        $frontUrl = rtrim(env('FRONT_URL', 'http://localhost:5173'), '/');

        $this->notifier->sendResetLink($musicUser->getEmail(), $frontUrl . '/reset?token=' . $token);
    }
}