<?php

namespace App\Models;

use App\Entity\Tracks\Track;
use App\Converter\Track\PrimitiveToTrackConverter;
use CodeIgniter\Database\BaseConnection;
use Config\Database;

final class TrackModel {
    private BaseConnection $database;
    private PrimitiveToTrackConverter $converter;

    public function __construct()
    {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToTrackConverter();
    }

    public function insert(Track $track): Track
    {
        $query = "INSERT INTO tracks (id_album, nombre, duracion, preview_url, orden, offset_preview) VALUES (?,?,?,?,?,?)";

        $this->database->query($query, [
            $track->getIdAlbum(),
            $track->getName(),
            $track->getDuration(),
            $track->getUrl(),
            $track->getOrden(),
            $track->getOffsetPreview()
        ]);

        $id = $this->database->insertID();

        return new Track(
            $id,
            $track->getIdAlbum(),
            $track->getName(),
            $track->getDuration(),
            $track->getUrl(),
            $track->getOrden(),
            $track->getOffsetPreview()
        );
    }

    /**
     * Trae todos los tracks de un álbum ya guardado, ordenados por su posición.
     * @return Track[]
     */
    public function findByAlbumId(int $idAlbum): array
    {
        $query = "SELECT * FROM tracks WHERE id_album = ? ORDER BY orden ASC";

        $result = $this->database->query($query, [$idAlbum]);

        $rows = $result->getResultArray();

        return array_map(
            fn($row) => $this->converter->convert($row),
            $rows
        );
    }


    public function actualizarOffset(int $idTrack, float $offset): void
{
    $query = "UPDATE tracks SET offset_preview = ? WHERE id = ?";
    $this->database->query($query, [$offset, $idTrack]);
}


public function findByNombreYArtista(string $nombre, string $artista): ?int
{
    $query = "SELECT t.id FROM tracks t
              JOIN albums a ON a.id = t.id_album
              WHERE t.nombre = ? AND a.artist = ?
              LIMIT 1";
    $result = $this->database->query($query, [$nombre, $artista]);
    $row = $result->getRow();
    return $row ? (int) $row->id : null;
}


}