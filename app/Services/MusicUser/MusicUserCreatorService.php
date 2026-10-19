<?php

namespace App\Services\MusicUser;

use App\Models\MusicUserModel;
use App\Entity\MusicUser\MusicUser;
use App\Converter\MusicUser\MusicUserToMusicUserResponseConverter;
use App\Dto\Request\MusicUser\MusicUserRequest;
use App\Dto\Response\MusicUser\MusicUserResponse;

final class MusicUserCreatorService{

    private MusicUserModel $musicUserModel;
    private MusicUserToMusicUserResponseConverter $converter;

    public function __construct()
    {
        $this->musicUserModel = new MusicUserModel();
        $this->converter = new MusicUserToMusicUserResponseConverter();

    }

    public function create(MusicUserRequest $request): MusicUserResponse
        {

$usuarioExistente = $this->musicUserModel->findByEmail($request->getEmail());

    if ($usuarioExistente !== null) {
        throw new \Exception('Ya existe una cuenta con ese email.', 409);
    }

            $musicUser = MusicUser::convertFromRequest($request);

            $newMusicUser = $this->musicUserModel->insert($musicUser);

            $musicUserResponse = $this->converter->convert($musicUser);

            return $musicUserResponse;
        }
}