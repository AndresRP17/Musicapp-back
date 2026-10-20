<?php

namespace App\Models;

use CodeIgniter\Database\BaseConnection;
use Config\Database;
use DateTime;

final class PasswordResetModel {

    private BaseConnection $database;

    public function __construct() {
        $this->database = Database::connect();
    }

    public function insert(int $idUser, string $tokenHash, string $expiresAt): void
    {
        $query = "INSERT INTO password_resets (id_user, token_hash, expires_at) VALUES (?,?,?)";
        $this->database->query($query, [$idUser, $tokenHash, $expiresAt]);
    }

    public function deleteByUser(int $idUser): void
    {
        $query = "DELETE FROM password_resets WHERE id_user = ?";
        $this->database->query($query, [$idUser]);
    }

    public function findValid(string $tokenHash): ?object
    {
        $now = (new DateTime())->format("Y-m-d H:i:s");

        $query = "SELECT P.id, P.id_user FROM password_resets P ";
        $query.= "WHERE P.token_hash = ? AND P.used = 0 AND P.expires_at >= ?";
        $result = $this->database->query($query, [$tokenHash, $now]);
        $row = $result->getRow();

        return empty($row) ? null : $row;
    }

    public function markUsed(int $id): void
    {
        $query = "UPDATE password_resets SET used = 1 WHERE id = ?";
        $this->database->query($query, [$id]);
    }
}