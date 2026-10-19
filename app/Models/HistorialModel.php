<?php


namespace App\Models;

use CodeIgniter\Database\BaseConnection;
use Config\Database;

final class HistorialModel {

    private BaseConnection $database;

    public function __construct()
    {
        $this->database = Database::connect();
    }

    public function insert(int $idUser, int $idTrack): void
    {
        $query = "INSERT INTO historial_reproduccion (id_user, id_track, reproducido_en) VALUES (?, ?, ?)";
        $this->database->query($query, [$idUser, $idTrack, date('Y-m-d H:i:s')]);
    }

    public function totalReproducciones(int $idUser): int
    {
        $query = "SELECT COUNT(*) as total FROM historial_reproduccion WHERE id_user = ?";
        $result = $this->database->query($query, [$idUser]);
        return (int) $result->getRow()->total;
    }

    public function minutosTotales(int $idUser): float
    {
        $query = "SELECT SUM(t.duracion) as segundos
                  FROM historial_reproduccion h
                  JOIN tracks t ON t.id = h.id_track
                  WHERE h.id_user = ?";
        $result = $this->database->query($query, [$idUser]);
        $segundos = $result->getRow()->segundos;

        return $segundos ? round($segundos / 60, 1) : 0;
    }

    public function generoFavorito(int $idUser): ?string
    {
        $query = "SELECT a.genre, COUNT(*) as total
                  FROM historial_reproduccion h
                  JOIN tracks t ON t.id = h.id_track
                  JOIN albums a ON a.id = t.id_album
                  WHERE h.id_user = ? AND a.genre IS NOT NULL
                  GROUP BY a.genre
                  ORDER BY total DESC
                  LIMIT 1";
        $result = $this->database->query($query, [$idUser]);
        $row = $result->getRow();

        return $row ? $row->genre : null;
    }

    public function artistaFavorito(int $idUser): ?string
    {
        $query = "SELECT a.artist, COUNT(*) as total
                  FROM historial_reproduccion h
                  JOIN tracks t ON t.id = h.id_track
                  JOIN albums a ON a.id = t.id_album
                  WHERE h.id_user = ?
                  GROUP BY a.artist
                  ORDER BY total DESC
                  LIMIT 1";
        $result = $this->database->query($query, [$idUser]);
        $row = $result->getRow();

        return $row ? $row->artist : null;
    }
}