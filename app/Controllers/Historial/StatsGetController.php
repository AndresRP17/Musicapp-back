<?php

namespace App\Controllers\Historial;

use CodeIgniter\RESTful\ResourceController;

class StatsGetController extends ResourceController
{
    public function obtener()
    {
        return $this->response->setJSON([
            'minutos_totales' => 0,
            'total_reproducciones' => 0,
            'genero_favorito' => null,
            'artista_favorito' => null
        ]);
    }
}