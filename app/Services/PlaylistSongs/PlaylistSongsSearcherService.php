<?php

namespace App\Services\PlaylistSongs;

use App\Models\PlaylistSongsModel;

final class PlaylistSongsSearcherService {

    private PlaylistSongsModel $playlistSongsModel;

    public function __construct(){
        $this->playlistSongsModel = new PlaylistSongsModel();
    }

    public function searchByPlaylistId(int $id_playlist): array
    {
        return $this->playlistSongsModel->searchByPlaylistId($id_playlist);
    }
}