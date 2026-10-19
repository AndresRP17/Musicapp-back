<?php

namespace App\Services\MusicUser;

use App\Models\MusicUserModel;

final class MusicUserDeletorService {

    private MusicUserModel $musicUserModel;
    private MusicUserFinderService $musicFinderService;

    public function __construct(){
        $this->musicUserModel = new MusicUserModel();
        $this->musicFinderService = new MusicUserFinderService();
    }

    public function delete(int $id) : void {
        
        $musicUser = $this->musicFinderService->find($id);

        $this->musicUserModel->delete($musicUser->getId());
    }
}