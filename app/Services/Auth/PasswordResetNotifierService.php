<?php

namespace App\Services\Auth;

/**
 * Entrega el link de recuperación al usuario.
 *
 * Por ahora (desarrollo) solo lo escribe en writable/logs/password-reset-links.log.
 * Cuando quieras mandar mails de verdad, el único lugar a cambiar es este método.
 */
final class PasswordResetNotifierService {

    public function sendResetLink(string $email, string $link): void
    {
        $directory = WRITEPATH . 'logs';

        // Si la carpeta no existe, se crea
        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $line = sprintf("[%s] %s -> %s\n", date('Y-m-d H:i:s'), $email, $link);

        file_put_contents($directory . '/password-reset-links.log', $line, FILE_APPEND);
    }
}