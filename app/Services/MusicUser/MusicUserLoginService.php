<?php


namespace App\Services\MusicUser;

use App\Dto\Request\MusicUser\MusicUserLoginRequest;
use App\Dto\Response\MusicUser\MusicUserLoginResponse;
use App\Models\MusicUserModel;
use App\Exception\MusicUser\MusicUserWrongPasswordException;
use App\Services\MusicUser\MusicUserFinderByEmailService;

final class MusicUserLoginService {
    private MusicUserModel $musicUserModel;
    private MusicUserFinderByEmailService $finder;


    public function __construct(){
        $this->musicUserModel = new MusicUserModel();
        $this->finder = new MusicUserFinderByEmailService();
    }

     public function login(MusicUserLoginRequest $request): MusicUserLoginResponse
    {
        $musicUser = $this->finder->find($request->getEmail());

        if ($musicUser->isGoogleAccount()) {
            throw new \Exception('Esta cuenta se creó con Google. Ingresá con el botón de Google.', 400);
        }

        if (!$musicUser->verifyPassword($request->getPassword())) {
            throw new MusicUserWrongPasswordException();
        }

        $musicUser->generateToken();

        $this->musicUserModel->update($musicUser);

        return new MusicUserLoginResponse($musicUser->getToken(), $musicUser->getRole(), $musicUser->getId(), $musicUser->getLogo() ?? '', $musicUser->getAuthProvider());
    
    }
}