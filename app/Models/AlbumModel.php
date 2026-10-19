<?php

namespace App\Models;

use App\Entity\Albums\Album;
use App\Converter\Album\PrimitiveToAlbumConverter;
use CodeIgniter\Database\BaseConnection;
use Config\Database;

final class AlbumModel {
    private BaseConnection $database;
    private PrimitiveToAlbumConverter $converter;


    public function __construct()
    {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToAlbumConverter();
    }


    public function insert(Album $album): Album
    {
        // Sacamos "id" del INSERT: es AUTO_INCREMENT, no hace falta (ni conviene) mandarlo a mano
        $query = "INSERT INTO albums (name, artist, portada_url, description, genre, creado_en) VALUES (?,?,?,?,?,?)";

        $this->database->query($query, [
            $album->getName(),
            $album->getArtist(),
            $album->getPortada(),
            $album->getDescription(),
            $album->getGenre(),
            $album->getCreado()
        ]);

        $id = $this->database->insertID();

        return new Album(
            $id,
            $album->getName(),
            $album->getArtist(),
            $album->getPortada(),
            $album->getDescription(),
            $album->getGenre(),
            $album->getCreado()
        );

    }

    /**
     * Busca un álbum por nombre + artista. Devuelve null si no existe.
     * Esto es lo que usa el Service para decidir si hace falta pedir a Last.fm o no.
     */
    public function findByNameAndArtist(string $name, string $artist): ?Album
    {
        $query = "SELECT * FROM albums WHERE name = ? AND artist = ? LIMIT 1";

        $result = $this->database->query($query, [$name, $artist]);

        $row = $result->getRowArray();

        if ($row === null) {
            return null;
        }

        // El converter traduce el array primitivo que devuelve la BD en un objeto Album real
        return $this->converter->convert($row);
    }


    /**
 * Busca álbumes ya guardados en NUESTRA base por género.
 * @return Album[]
 */
public function findByGenre(string $genero): array
{
    $query = "SELECT * FROM albums WHERE genre = ? ORDER BY id DESC";
    $result = $this->database->query($query, [$genero]);

    return array_map(
        fn($row) => $this->converter->convert($row),
        $result->getResultArray()
    );
}
}