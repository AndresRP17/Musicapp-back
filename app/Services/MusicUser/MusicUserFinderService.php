<?php

namespace App\Services\MusicUser;

use App\Converter\MusicUser\MusicUserToMusicUserResponseConverter;
use App\Dto\Response\MusicUser\MusicUserResponse;
use App\Entity\MusicUser\MusicUser;
use App\Models\MusicUserModel;
use App\Exception\MusicUser\MusicUserNotFoundException;

final class MusicUserFinderService{

    private MusicUserModel $musicUserModel;
    private MusicUserToMusicUserResponseConverter $converter;

    public function __construct() {
        $this->musicUserModel = new MusicUserModel();
        $this->converter = new MusicUserToMusicUserResponseConverter();
    }

    public function find(int $id): MusicUser
    {
        $musicUser = $this->musicUserModel->find($id);

        if (empty($musicUser)) {
            throw new MusicUserNotFoundException($id);
       
        }
        return $musicUser;
    }

    public function findResponse(int $id): MusicUserResponse
    {

        $musicUser = $this->find($id);

        $response = $this->converter->convert($musicUser);

        return $response;

    }

}