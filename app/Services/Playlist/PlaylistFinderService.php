<?php

namespace App\Services\Playlist;

use App\Models\PlaylistModel;
use App\Exception\Playlist\PlaylistNotFoundException;



final class PlaylistFinderService{
    private PlaylistModel $playlistModel;

    public function __Construct() {
        $this->playlistModel = new PlaylistModel();

    }

    public function find(int $id): object
    {
        $playlist = $this->playlistModel->find($id);

        if (empty($playlist)) {
            throw new PlaylistNotFoundException($id);
        }
        return $playlist;
    }
}