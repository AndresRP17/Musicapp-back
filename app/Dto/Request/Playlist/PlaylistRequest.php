<?php

namespace App\Dto\Request\Playlist;

final readonly class PlaylistRequest{
    public function __construct(
        private int $idUser,
        private string $name
    ){}

    public function getIdUser(): int
    {
        return $this->idUser;
    }

    public function getName(): string
    {
        return $this->name;
    }

}