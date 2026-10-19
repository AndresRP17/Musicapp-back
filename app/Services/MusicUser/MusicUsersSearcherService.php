<?php

namespace App\Services\MusicUser;

use App\Converter\MusicUser\MusicUserToMusicUserResponseConverter;
use App\Models\MusicUserModel;

final class MusicUsersSearcherService {

    private MusicUserModel $musicUserModel;
    private MusicUserToMusicUserResponseConverter $converter;

    public function __construct() {
        $this->musicUserModel = new MusicUserModel();
        $this->converter = new MusicUserToMusicUserResponseConverter();
    }

    public function search() : Array {
        return $this->musicUserModel->search();
    }
}