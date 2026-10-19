<?php

namespace App\Entity\Playlist;
use App\Dto\Request\Playlist\PlaylistRequest;
use JsonSerializable;

final class Playlist implements JsonSerializable {  
    public function __construct(
        private ?int $id,
        private int $id_user,
        private string $name
    ){}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): int
    {
        return $this->id_user;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function convertFromRequest(PlaylistRequest $request): Playlist
    {
        return new Playlist(
            null,
            $request->getIdUser(),
            $request->getName()
        );
    }

    public function jsonSerialize(): array  
    {
        return [
            'id'      => $this->id,
            'id_user' => $this->id_user,
            'name'    => $this->name,
        ];
    }
}