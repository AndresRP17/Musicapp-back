<?php


namespace App\Entity\Favorite;

use App\Dto\Request\Favorite\FavoriteRequest;
use JsonSerializable;


final class Favorite implements JsonSerializable {
    public function __construct(
        private ?int $id,
        private int $id_user,
        private string $title,
        private string $artist,
        private string $album,
        private int $duration,
        private string $genre
    ){}
        

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): int
    {
        return $this->id_user;
    }


    public function getTitle(): string
    {
        return $this->title;
    }

     public function getArtist(): string
    {
        return $this->artist;
    }

     public function getAlbum(): string
    {
        return $this->album;
    }

     public function getDuration(): int
    {
        return $this->duration;

    }

    public function getGenre(): string
    {
        return $this->genre;
    }
   
    public static function convertFromRequest(FavoriteRequest $request): Favorite
    {
        return new Favorite(
            null,
            $request->getIdUser(),
            $request->getTitle(),
            $request->getArtist(),
            $request->getAlbum(),
            $request->getDuration(),
            $request->getGenre()
        );
    }

     public function jsonSerialize(): array
    {
        return [
            'id'       => $this->id,
            'id_user'  => $this->id_user,
            'title'    => $this->title,
            'artist'   => $this->artist,
            'album'    => $this->album,
            'duration' => $this->duration,
            'genre'    => $this->genre
        ];
    }
}
