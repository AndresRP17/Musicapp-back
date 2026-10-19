<?php

namespace App\Dto\Response\Historial;


final readonly class HistorialResponse{
    public function __construct(
     public ?int $id,
     public int $idUser,
     public int $idTrack,
     public string $creado
    
    )
    {}
}