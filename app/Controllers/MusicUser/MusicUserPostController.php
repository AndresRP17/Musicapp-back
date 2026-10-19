<?php

namespace App\Controllers\MusicUser;

use App\Dto\Request\MusicUser\MusicUserRequest;
use App\Services\MusicUser\MusicUserCreatorService;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class MusicUserPostController extends ResourceController {

    private MusicUserCreatorService $musicUserCreatorService;

    public function __construct() {
        $this->musicUserCreatorService = new MusicUserCreatorService();
    }
    

    public function create(): ResponseInterface
    {
         $body = $this->request->getBody();
         $musicUserRequest = $this->getRequest();
         
         $musicUserResponse = $this->musicUserCreatorService->create($musicUserRequest);
       

        return $this->response->setJSON($musicUserResponse);
    }


    public function getRequest(): MusicUserRequest
    {
        $parameters = $this->request->getJSON();

        return new MusicUserRequest(
            $parameters->email,
            $parameters->password,
            $parameters->role ?? 'user',
            $parameters->logo ?? "/yuuta.jpg"
           
        );
    }
}