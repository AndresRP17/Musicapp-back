<?php

namespace App\Converter\MusicUser;

use App\Entity\MusicUser\MusicUser;
use App\Dto\Response\MusicUser\MusicUserResponse;


final class MusicUserToMusicUserResponseConverter
{
    public function convert(MusicUser $musicUser): MusicUserResponse

    {
        return new MusicUserResponse(
            $musicUser->getId(),
            $musicUser->getEmail(),
            $musicUser->getPassword(),
            $musicUser->getRole(),
            $musicUser->getLogo()
        );
    }
}   