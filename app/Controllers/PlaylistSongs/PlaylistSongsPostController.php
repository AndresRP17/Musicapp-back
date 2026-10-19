<?php

namespace App\Controllers\PlaylistSongs;

use App\Dto\Request\PlaylistSongs\PlaylistSongsRequest;
use App\Services\PlaylistSongs\PlaylistSongsCreatorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Override;

class PlaylistSongsPostController extends ResourceController 
{
    private PlaylistSongsCreatorService $playlistSongsCreatorService;

    public function __construct()
    {
        $this->playlistSongsCreatorService = new PlaylistSongsCreatorService();
    }

    #[Override]
    public function create(): ResponseInterface
    {
        $playlistSongsRequest = $this->getRequest();

        try {
            $playlistSongsResponse = $this->playlistSongsCreatorService->create($playlistSongsRequest);
            return $this->response->setJSON($playlistSongsResponse);
        } catch (\RuntimeException $e) {
            return $this->response
                ->setStatusCode($e->getCode())
                ->setJSON(['error' => $e->getMessage()]);
        }
    }

    public function getRequest(): PlaylistSongsRequest
    {
        $parameters = $this->request->getJSON();

        return new PlaylistSongsRequest(
            null,
            $parameters->id_playlist ?? null,
            $parameters->title ?? null,
            $parameters->artist ?? null,
            $parameters->album ?? null,
            $parameters->duration ?? null,
            $parameters->genre ?? null
        );
    }
}