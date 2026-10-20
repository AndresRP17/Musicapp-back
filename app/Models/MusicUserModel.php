<?php

namespace App\Models;

use App\Converter\MusicUser\PrimitiveToMusicUserConverter;
use App\Entity\MusicUser\MusicUser;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use Datetime;

final class MusicUserModel {

    private BaseConnection $database;
    private PrimitiveToMusicUserConverter $converter;

    public function __construct() {
        $this->database = Database::connect();
        $this->converter = new PrimitiveToMusicUserConverter();
    }

    public function insert(MusicUser $musicUser): MusicUser
    {
        $query = "INSERT INTO music_users (email, password, role, token, token_expiration_date, auth_provider) VALUES (?,?,?,?,?,?)";

        $this->database->query($query, [
            $musicUser->getEmail(),
            $musicUser->getPassword(),
            $musicUser->getRole(),
            $musicUser->getToken(),
            $musicUser->getTokenExpirationDate(),
            $musicUser->getAuthProvider()
        ]);

        $id = $this->database->insertID();

        return new MusicUser(
            $id,
            $musicUser->getEmail(),
            $musicUser->getPassword(),
            $musicUser->getRole(),
            $musicUser->getToken(),
            $musicUser->getTokenExpirationDate(),
            $musicUser->getLogo(),
            $musicUser->getAuthProvider()
        );
    }

    public function update(MusicUser $musicUser): MusicUser
    {
        $query = "UPDATE music_users SET email = ?, password = ?, role = ?, ";
        $query.= "token = ?, token_expiration_date = ? ";
        $query.= "WHERE id = ?";

        $expirationDate = $musicUser->getTokenExpirationDate();
        $formattedDate = $expirationDate instanceof DateTime ? $expirationDate->format("Y-m-d H:i:s") : null;

        $this->database->query($query, [
            $musicUser->getEmail(),
            $musicUser->getPassword(),
            $musicUser->getRole(),
            $musicUser->getToken(),
            $formattedDate,
            $musicUser->getId()
        ]);

        return $musicUser;
    }

    public function find(int $id): ?MusicUser
    {
        $query = "SELECT M.id, M.email, M.password, M.role, M.token, M.token_expiration_date, M.logo, M.auth_provider FROM music_users M WHERE M.id = ?";
        $result = $this->database->query($query, [$id]);
        $primitive = $result->getRow();

        if (empty($primitive)) {
            return null;
        }

        return $this->converter->convert($primitive);
    }

    public function search(): array
    {
        $query = "SELECT M.id, M.email, M.password, M.role, M.token, M.token_expiration_date, M.logo, M.auth_provider FROM music_users M";
        $result = $this->database->query($query);

        return $result->getResult();
    }

    public function delete(int $id): void
    {
        $query = "DELETE FROM music_users WHERE id = ?";
        $this->database->query($query, [$id]);
    }

    public function findByEmail(string $email): ?MusicUser
    {
        $query = "SELECT M.id, M.email, M.password, M.role, M.token, M.token_expiration_date, M.logo, M.auth_provider FROM music_users M WHERE M.email = ?";
        $result = $this->database->query($query, [$email]);
        $primitive = $result->getRow();

        if (empty($primitive)) {
            return null;
        }

        return $this->converter->convert($primitive);
    }

    public function findByToken(string $token): ?MusicUser
    {
        $now = new Datetime();
        $dateNow = $now->format("Y-m-d H:i:s");

        $query = "SELECT M.id, M.email, M.password, M.role, M.token, M.token_expiration_date, M.logo, M.auth_provider ";
        $query.= "FROM music_users M ";
        $query.= "WHERE M.token = ? AND M.token_expiration_date >= ?";
        $result = $this->database->query($query, [$token, $dateNow]);
        $primitive = $result->getRow();

        if (empty($primitive)) {
            return null;
        }

        return $this->converter->convert($primitive);
    }


    public function updateLogo(string $token, string $logo): void
    {
        $query = "UPDATE music_users SET logo = ? WHERE token = ?";
        $this->database->query($query, [$logo, $token]);
    }


    public function updateRole(string $token, string $role): void
    {
        $query = "UPDATE music_users SET role = ? WHERE  token = ?";
        $this->database->query($query, [$role, $token]);
    }

    public function findWithPlaylistsAndSongs(int $id): array
{
    $query = "SELECT mu.id, mu.email, mu.role, mu.logo,
                     p.id as playlist_id, p.name as playlist_name,
                     ps.title, ps.artist, ps.album, ps.duration, ps.genre
              FROM music_users mu
              LEFT JOIN playlists p ON p.id_user = mu.id
              LEFT JOIN playlist_songs ps ON ps.id_playlist = p.id
              WHERE mu.id = ?
              ORDER BY p.id, ps.id";

    $result = $this->database->query($query, [$id]);
    return $result->getResult();
}
}