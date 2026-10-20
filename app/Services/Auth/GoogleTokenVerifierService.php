<?php

namespace App\Services\Auth;

use App\Exception\Auth\GoogleTokenInvalidException;
use Config\Services;
use RuntimeException;
use Throwable;

final class GoogleTokenVerifierService {
    private const TOKENINFO_URL = 'https://oauth2.googleapis.com/tokeninfo';
    private const VALID_ISSUERS = ['accounts.google.com', 'https://accounts.google.com'];

    /**
     * Valida el ID token que manda el front con Google y devuelve el email verificado.
     */
    public function verify(string $credential): string
    {
        $clientId = env('GOOGLE_CLIENT_ID');

        if (empty($clientId)) {
            throw new RuntimeException('Falta GOOGLE_CLIENT_ID en el .env del backend', 500);
        }

        if (empty($credential)) {
            throw new GoogleTokenInvalidException('Falta el token de Google');
        }

        try {
            $client = Services::curlrequest(['timeout' => 10, 'http_errors' => false], null, null, false);
            $response = $client->get(self::TOKENINFO_URL, ['query' => ['id_token' => $credential]]);
        } catch (Throwable $e) {
            throw new GoogleTokenInvalidException('No se pudo contactar a Google para validar el token', 502);
        }

        if ($response->getStatusCode() !== 200) {
            throw new GoogleTokenInvalidException();
        }

        $data = json_decode($response->getBody(), true);

        if (!is_array($data)) {
            throw new GoogleTokenInvalidException();
        }

        $audienceOk = ($data['aud'] ?? null) === $clientId;
        $issuerOk = in_array($data['iss'] ?? '', self::VALID_ISSUERS, true);
        $emailVerified = filter_var($data['email_verified'] ?? false, FILTER_VALIDATE_BOOLEAN);

        if (!$audienceOk || !$issuerOk || !$emailVerified || empty($data['email'])) {
            throw new GoogleTokenInvalidException();
        }

        return strtolower($data['email']);
    }
}