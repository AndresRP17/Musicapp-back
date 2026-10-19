<?php

namespace App\Controllers\Playlist;

use App\Dto\Request\Playlist\PlaylistRequest;
use App\Services\Playlist\PlaylistCreatorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class PlaylistPostController extends ResourceController
{
    private PlaylistCreatorService $playlistCreatorService;

    public function __construct() 
    {
        $this->playlistCreatorService = new PlaylistCreatorService();
    }

    public function create(): ResponseInterface
    {
        // 1. Obtenemos el DTO llamando a tu método interno
        $playlistRequest = $this->getRequest();

        // 2. Le pasamos el DTO ($playlistRequest) al servicio, NO $request
        $playlistResponse = $this->playlistCreatorService->create($playlistRequest);

        // 3. Corregido 'setJeson' por 'setJSON'
        return $this->response->setJSON($playlistResponse);
    }
 
    public function getRequest(): PlaylistRequest
    {
        // En CodeIgniter 4 se usa $this->request
        $parameters = $this->request->getJSON();

        // Evitamos el error de "Undefined property" dándole un valor por defecto si no viene en el JSON
        $idUser = $parameters->id_user ?? null;
        $name = $parameters->name ?? null;

        return new PlaylistRequest(
            $idUser,    
            $name
        );
    }
}