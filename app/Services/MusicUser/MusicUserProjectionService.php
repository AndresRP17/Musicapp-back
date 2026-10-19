<?php

namespace App\Services\MusicUser;

use App\Models\MusicUserModel;
use App\Exception\MusicUser\MusicUserNotFoundException;

final class MusicUserProjectionService {

    private MusicUserModel $musicUserModel;

    public function __construct() {
        $this->musicUserModel = new MusicUserModel();
    }

    public function findProjected(int $id): array
    {
        $rows = $this->musicUserModel->findWithPlaylistsAndSongs($id);

        if (empty($rows)) {
            throw new MusicUserNotFoundException($id);
        }

        $user = [
            'id'        => $rows[0]->id,
            'email'     => $rows[0]->email,
            'role'      => $rows[0]->role,
            'logo'      => $rows[0]->logo,
            'playlists' => []
        ];

        foreach ($rows as $row) {
            if (!$row->playlist_id) continue;

            if (!isset($user['playlists'][$row->playlist_id])) {
                $user['playlists'][$row->playlist_id] = [
                    'id'        => $row->playlist_id,
                    'name'      => $row->playlist_name,
                    'canciones' => []
                ];
            }

            if ($row->title) {
                $user['playlists'][$row->playlist_id]['canciones'][] = [
                    'title'    => $row->title,
                    'artist'   => $row->artist,
                    'album'    => $row->album,
                    'duration' => $row->duration,
                    'genre'    => $row->genre
                ];
            }
        }

        $user['playlists'] = array_values($user['playlists']);

        return $user;
    }
}