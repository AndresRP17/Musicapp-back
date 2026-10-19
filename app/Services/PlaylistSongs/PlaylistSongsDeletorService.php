<?php

namespace App\Services\PlaylistSongs;

use App\Models\PlaylistSongsModel;
use App\Services\PlaylistSongs\PlaylistSongsFinderService;

final class PlaylistSongsDeletorService {

    private PlaylistSongsModel $playlistSongsModel;
    private PlaylistSongsFinderService $finder;

    public function __construct(){

        $this->playlistSongsModel = new PlaylistSongsModel();
        $this->finder = new PlaylistSongsFinderService();
    }

    public function delete(int $id): void
    {
        $playlistSongs = $this->finder->find($id);
        $this->playlistSongsModel->delete($playlistSongs->getId());
    }
}