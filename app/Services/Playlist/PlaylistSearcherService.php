<?php

namespace App\Services\Playlist;


use App\Models\PlaylistModel;


final class PlaylistSearcherService {
    private PlaylistModel $playlistModel;

    public function __construct(){
        $this->playlistModel = new PlaylistModel();
    }

    public function searchByUserId(int $id_user): array
    {
        return $this->playlistModel->searchByUserId($id_user);
    }
}