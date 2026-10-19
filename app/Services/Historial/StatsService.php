<?php

namespace App\Services\Historial;

use App\Models\HistorialModel;

final class StatsService
{
    private HistorialModel $historialModel;

    public function __construct()
    {
        $this->historialModel = new HistorialModel();
    }

    public function obtenerEstadisticas(int $idUser): array
    {
        $minutosTotales = $this->historialModel->minutosTotales($idUser);
        $generoFavorito = $this->historialModel->generoFavorito($idUser);
        $artistaFavorito = $this->historialModel->artistaFavorito($idUser);
        $totalReproducciones = $this->historialModel->totalReproducciones($idUser);

        return [
            'minutos_totales'      => $minutosTotales,
            'genero_favorito'      => $generoFavorito,
            'artista_favorito'     => $artistaFavorito,
            'total_reproducciones' => $totalReproducciones,
        ];
    }
}