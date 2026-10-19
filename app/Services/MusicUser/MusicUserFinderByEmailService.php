<?php

namespace App\Services\MusicUser;

use App\Converter\MusicUser\MusicUserToMusicUserResponseConverter;
use App\Exception\MusicUser\MusicUserNotFoundByEmailException;
use App\Models\MusicUserModel;
use App\Entity\MusicUser\MusicUser;

final class MusicUserFinderByEmailService{

    private MusicUserModel $musicUserModel;
    private MusicUserToMusicUserResponseConverter $converter;

    public function __construct() {
        $this->musicUserModel = new MusicUserModel();
        $this->converter = new MusicUserToMusicUserResponseConverter();
    }

public function find(string $email): MusicUser 
    {
        $musicUser = $this->musicUserModel->findByEmail($email);

        if (empty($musicUser)) {
            throw new MusicUserNotFoundByEmailException($email);
        }

        return $musicUser;
    }

    }
