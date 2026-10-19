<?php

namespace App\Services\Playlist;

use App\Models\PlaylistModel;

final class PlaylistDeletorService{

    private PlaylistModel $playlistModel;
    private PlaylistFinderService $seacher;

    public function __construct(){

        $this->playlistModel = new PlaylistModel();
        $this->seacher = new PlaylistFinderService();
    }

    public function delete(int $id): void
    {
        $playlist = $this->seacher->find($id);
        $this->playlistModel->delete($playlist->getId());
    }
}
