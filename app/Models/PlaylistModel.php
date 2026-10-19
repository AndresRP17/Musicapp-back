<?php

namespace App\Models;

use App\Converter\Playlist\PrimitiveToPlaylistConverter;
use App\Entity\Playlist\Playlist;
use Config\Database;
use Codeigniter\Database\BaseConnection;

final class PlaylistModel {

    private BaseConnection $database;
    private PrimitiveToPlaylistConverter $converter;

    public function __construct()
    {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToPlaylistConverter();
    }

    public function insert(Playlist $playlist): Playlist
    {
        $query = "INSERT INTO playlists (id_user, name) VALUES (?,?) ";

        $this->database->query($query, [
            $playlist->getIdUser(),
            $playlist->getName()
        ]);

        $id = $this->database->insertID();

        return new Playlist(
            $id,
            $playlist->getIdUser(),
            $playlist->getName()
        );
    }

    public function find(int $id): ?Playlist
    {
        $query = "SELECT P.id, P.id_user, P.name FROM playlists P WHERE P.id = ?";
        $result = $this->database->query($query, [$id]);
        $primitive = $result->getRow();

        if (empty($primitive)) {
            return null;
        }
        return $this->converter->converter($primitive);
    }

    public function searchByUserId(int $id_user): array
    {
        $query = "SELECT P.id, P.id_user, P.name FROM playlists P WHERE P.id_user = ? ORDER BY id DESC";
        $result = $this->database->query($query, [$id_user]);

        return array_map(
        fn($primitive) => $this->converter->converter($primitive),
        $result->getResult()
    );
}
        public function delete(int $id): void
        {
            $query = "DELETE FROM playlists WHERE id = ?";
            $this->database->query($query,[$id]);
        }
    }
