<?php

namespace App\Services\Playlist;

use App\Converter\Playlist\PlaylistToPlaylistResponseConverter;
use App\Dto\Request\Playlist\PlaylistRequest;
use App\Dto\Response\Playlist\PlaylistResponse;
use App\Models\PlaylistModel;
use App\Entity\Playlist\Playlist;

final class PlaylistCreatorService{

    private PlaylistModel $playlistModel;
    private PlaylistToPlaylistResponseConverter $converter;

    public function __construct()
    {
        $this->playlistModel = new PlaylistModel();
        $this->converter = new PlaylistToPlaylistResponseConverter();
    }

    public function create(PlaylistRequest $request): PlaylistResponse

    {
        $playlist = Playlist::convertFromRequest($request);

        $newPlaylist = $this->playlistModel->insert($playlist);

        $playlistResponse = $this->converter->converter($newPlaylist);

        return $playlistResponse;
    }

}