<?php

namespace App\Controllers\Favorite;

use App\Dto\Request\Favorite\FavoriteRequest;
use App\Services\Favorite\FavoriteCreatorService;
use App\Models\MusicUserModel; 
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class FavoritePostController extends ResourceController {

    private FavoriteCreatorService $favoriteCreatorService;

    public function __construct() {
        $this->favoriteCreatorService = new FavoriteCreatorService();
    }

    public function create(): ResponseInterface
    {
       
        $authHeader = $this->request->getHeaderLine('Authorization');
        $token = str_replace('Bearer ', '', $authHeader);

      
        $userModel = new MusicUserModel();
        $usuario = $userModel->findByToken($token); 

        if (!$usuario) {
            return $this->failUnauthorized('Token inválido o expirado.');
        }

        
        $parameters = $this->request->getJSON();

        
        $favoriteRequest = new FavoriteRequest(
            (int)$usuario->getId(), 
            $parameters->title,
            $parameters->artist,
            $parameters->album,
            (int)$parameters->duration,
            $parameters->genre
        );

         try {
        $favoriteResponse = $this->favoriteCreatorService->create($favoriteRequest);
        return $this->response->setJSON($favoriteResponse);
    } catch (\RuntimeException $e) {
        return $this->response
            ->setStatusCode($e->getCode())
            ->setJSON(['error' => $e->getMessage()]);

}
    }}