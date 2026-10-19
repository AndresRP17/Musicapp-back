<?php

namespace App\Converter\MusicUser;

use App\Entity\MusicUser\MusicUser;
use Datetime;

final class PrimitiveToMusicUserConverter {

    public function convert(object $primitive): MusicUser
    {
        return new MusicUser(
            $primitive->id,
            $primitive->email,
            $primitive->password,
            $primitive->role,
            $primitive->token,
           new DateTime($primitive->token_expiration_date),
           $primitive->logo
        );
    }
}