<?php

namespace App\Models;

use App\Converter\Favorite\PrimitiveToFavoriteConverter;
use App\Entity\Favorite\Favorite;
use Config\Database;
use CodeIgniter\Database\BaseConnection;

final class FavoriteModel {

    private BaseConnection $database;
    private PrimitiveToFavoriteConverter $converter;

    public function __construct()
    {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToFavoriteConverter();

    }

    public function insert(Favorite $favorite): Favorite

    {
        $query = "INSERT INTO favorites (id_user, title, artist, album, duration, genre) VALUES (?,?,?,?,?,?) ";
   
        $this->database->query($query, [
            $favorite->getIdUser(),
            $favorite->getTitle(),
            $favorite->getArtist(),
            $favorite->getAlbum(),
            $favorite->getDuration(),
            $favorite->getGenre()
        ]);

        $id = $this->database->insertID();

        return new Favorite(
            
           $id,
           $favorite->getIdUser(),
            $favorite->getTitle(),
            $favorite->getArtist(),
            $favorite->getAlbum(),
            $favorite->getDuration(),
            $favorite->getGenre()
        );
 }

        public function find(int $id): ?Favorite
{
    $query = "SELECT F.id, F.id_user, F.title, F.artist, F.album, F.duration, F.genre 
              FROM favorites F 
              WHERE F.id = ?"; 

    $result = $this->database->query($query, [$id]);
    $primitive = $result->getRow();

    if (empty($primitive)) {
        return null;
    }

    return $this->converter->convert($primitive);
}

public function searchByUserId(int $id_user): array
{
    $query = "SELECT F.id, F.id_user, F.title, F.artist, F.album, F.duration, F.genre 
              FROM favorites F 
              WHERE F.id_user = ? 
              ORDER BY id DESC";

    $result = $this->database->query($query, [$id_user]);

    // Convertir cada fila a Favorite
    return array_map(
        fn($primitive) => $this->converter->convert($primitive),
        $result->getResult()
    );
}
        public function delete(int $id): void
        {
            $query = "DELETE FROM favorites WHERE id = ?";
            $this->database->query($query,[$id]);
        }

        public function existsByUserAndSong(int $idUser, string $title, string $artist): bool
{
    $query = "SELECT COUNT(*) as total FROM favorites WHERE id_user = ? AND title = ? AND artist = ?";
    $result = $this->database->query($query, [$idUser, $title, $artist]);
    return $result->getRow()->total > 0;
}
}


