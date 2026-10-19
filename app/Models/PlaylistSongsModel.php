<?php

namespace App\Models;

use App\Converter\PlaylistSongs\PrimitiveToPlaylistSongsConverter;
use App\Entity\PlaylistSongs\PlaylistSongs;
use CodeIgniter\Database\BaseConnection;
use Config\Database;

final class PlaylistSongsModel{

    private BaseConnection $database;
    private PrimitiveToPlaylistSongsConverter $converter;

    public function __construct()
    {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToPlaylistSongsConverter();
    }

    public function insert(PlaylistSongs $playlistSongs): PlaylistSongs
    {
        $query = "INSERT INTO playlist_songs (id_playlist, title, artist, album, duration, genre) VALUES (?,?,?,?,?,?) ";

        $this->database->query($query, [
            $playlistSongs->getIdPlaylist(),
            $playlistSongs->getTitle(),
            $playlistSongs->getArtist(),
            $playlistSongs->getAlbum(),
            $playlistSongs->getDuration(),
            $playlistSongs->getGenre()
        ]);

        $id = $this->database->insertID();

        return new PlaylistSongs(
            $id,
            $playlistSongs->getIdPlaylist(),
            $playlistSongs->getTitle(),
            $playlistSongs->getArtist(),
            $playlistSongs->getAlbum(),
            $playlistSongs->getDuration(),
            $playlistSongs->getGenre()
        );
     }

     public function find(int $id): ?PlaylistSongs
     {
        $query = "SELECT Ps.id, Ps.id_playlist, Ps.title, Ps.artist, Ps.album, Ps.duration, Ps.genre
        FROM playlist_songs Ps
        WHERE Ps.id = ? ";

        $result = $this->database->query($query, [$id]);
        $primitive = $result->getRow();

        if (empty($primitive)) {
            return null;
        }
        return $this->converter->converter($primitive);
     }


     public function searchByPlaylistId(int $id): array
{
    $query = "SELECT id, id_playlist, title, artist, album, duration, genre
        FROM playlist_songs
        WHERE id_playlist = ?
        ORDER BY id DESC
    ";

    $result = $this->database->query($query, [$id]);

    return array_map(
        fn($primitive) => $this->converter->converter($primitive),
        $result->getResult()
    );
}

    public function delete (int $id): void
    {
        $query = "DELETE FROM playlist_songs WHERE id = ?";
        $this->database->query($query, [$id]);
    }



public function existsByPlaylistAndSong(int $idPlaylist, string $title, string $artist): bool
{
    $query = "SELECT COUNT(*) as total FROM playlist_songs WHERE id_playlist = ? AND title = ? AND artist = ?";
    $result = $this->database->query($query, [$idPlaylist, $title, $artist]);
    return $result->getRow()->total > 0;
}

}