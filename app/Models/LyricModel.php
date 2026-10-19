<?php

namespace App\Models;

use App\Entity\Lyrics\Lyric;
use App\Converter\Lyric\PrimitiveToLyricConverter;
use CodeIgniter\Database\BaseConnection;
use Config\Database;

final class LyricModel {
    private BaseConnection $database;
    private PrimitiveToLyricConverter $converter;


public function __construct()
{
    $this->database = Database::connect();
    $this->converter = new PrimitiveToLyricConverter();
}

public function insert(Lyric $lyric): Lyric
    {
        // Sacamos "id" del INSERT: es AUTO_INCREMENT, MySQL lo genera solo
        $query = "INSERT INTO lyrics (id_track, letra_sincronizada, letra_plana, creado_en) VALUES (?,?,?,?)";

        $this->database->query($query, [
            $lyric->getIdTrack(),
            $lyric->getLetra(),
            $lyric->getLetraPlana(),
            $lyric->getCreado()
        ]);

        $id = $this->database->insertID();

        return new Lyric(
            $id,
            $lyric->getIdTrack(),
            $lyric->getLetra(),
            $lyric->getLetraPlana(),
            $lyric->getCreado()
        );
    }

    /**
     * Busca la letra guardada de un track puntual. Devuelve null si no existe.
     * Esto es lo que usa el Service para decidir si hace falta pedir a lrclib.net o no.
     */
    public function findByTrackId(int $idTrack): ?Lyric
    {
        $query = "SELECT * FROM lyrics WHERE id_track = ? LIMIT 1";

        $result = $this->database->query($query, [$idTrack]);

        $row = $result->getRowArray();

        if ($row === null) {
            return null;
        }

        return $this->converter->convert($row);
    }

}