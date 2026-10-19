<?php

namespace App\Services\PlaylistSongs;

use App\Converter\PlaylistSongs\PlaylistSongsToPlaylistSongsResponseConverter;
use App\Dto\Request\PlaylistSongs\PlaylistSongsRequest;
use App\Dto\Response\PlaylistSongs\PlaylistSongsResponse;
use App\Models\PlaylistSongsModel;
use App\Entity\PlaylistSongs\PlaylistSongs;
use RuntimeException;

final class PlaylistSongsCreatorService {

    private PlaylistSongsModel $playlistSongsModel;
    private PlaylistSongsToPlaylistSongsResponseConverter $converter;

    public function __construct()
    {
        $this->playlistSongsModel = new PlaylistSongsModel();
        $this->converter = new PlaylistSongsToPlaylistSongsResponseConverter();
    }

    public function create(PlaylistSongsRequest $request): PlaylistSongsResponse
    {
        $existe = $this->playlistSongsModel->existsByPlaylistAndSong(
            $request->getIdPlaylist(),
            $request->getTitle(),
            $request->getArtist()
        );

        if ($existe) {
            throw new RuntimeException('La canción ya está en esta playlist', 409);
        }

        $playlistSongs = PlaylistSongs::convertFromRequest($request);
        $newPlaylistSongs = $this->playlistSongsModel->insert($playlistSongs);
        $playlistSongsResponse = $this->converter->converter($newPlaylistSongs);

        return $playlistSongsResponse;
    }
}