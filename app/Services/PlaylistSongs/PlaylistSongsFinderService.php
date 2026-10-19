<?php

namespace App\Services\PlaylistSongs;

use App\Models\PlaylistSongsModel;
use App\Exception\PlaylistSongs\PlaylistSongsNotFoundException;

final class PlaylistSongsFinderService {

    private PlaylistSongsModel $playlistSongsModel;


    public function __construct()
    {
        $this->playlistSongsModel = new PlaylistSongsModel();
    }

    public function find (int $id): object
    {
        $playlistSongs = $this->playlistSongsModel->find($id);

        if (empty($playlistSongs)) {
            throw new PlaylistSongsNotFoundException($id);
        } 
        return $playlistSongs;
    }

}