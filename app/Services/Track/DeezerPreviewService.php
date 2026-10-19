<?php

namespace App\Services\Track;

use Config\Services;

final class DeezerPreviewService
{
    /**
     * Busca una canción en Deezer y devuelve la URL de preview (30 seg de mp3).
     * Devuelve null si no encuentra nada o si Deezer falla (nunca rompe el flujo de álbum).
     */
    public function buscarPreview(string $artista, string $nombreCancion): ?string
    {
        try {
            $client = Services::curlrequest();

            $query = trim($artista . ' ' . $nombreCancion);

            $response = $client->get('https://api.deezer.com/search', [
                'query' => [
                    'q' => $query,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (empty($data['data'])) {
                return null;
            }

            // Nos quedamos con el primer resultado (el más relevante según Deezer)
            return $data['data'][0]['preview'] ?? null;

        } catch (\Exception $e) {
            log_message('error', 'Error buscando preview en Deezer: ' . $e->getMessage());
            return null;
        }
    }
}