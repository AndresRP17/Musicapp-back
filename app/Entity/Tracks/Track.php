<?php

namespace App\Entity\Tracks;
use App\Dto\Request\Track\TrackRequest;

use JsonSerializable;
use Override;

final class Track implements JsonSerializable {
    public function __construct(
        private ?int $id,
        private int $idAlbum,
        private string $name,
        private int $duration,
        private ?string $url,
        private int $orden,
        private ?float $offsetPreview = null  // ← nuevo, al final para no romper llamadas viejas


    ){}

    public function getId(): ?int{
        return $this->id;
    }

    public function getIdAlbum(): int
    {
        return $this->idAlbum;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDuration(): int{
        return $this->duration;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getOrden(): int
    {
        return $this->orden;
    }

public function getOffsetPreview(): ?float
{
    return $this->offsetPreview;
}

    public static function convertFromRequest(TrackRequest $request): Track
    {
        return new Track(
            $request->getId(),
            $request->getIdAlbum(),
            $request->getName(),
            $request->getDuration(),
            $request->getUrl(),
            $request->getOrden(),
            $request->getOffsetPreview()

        );
    }

    #[Override]
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'idAlbum' => $this->idAlbum,
            'name' => $this->name,
            'duration' => $this->duration,
            'url' => $this->url,
            'orden' => $this->orden
        ];
    }

}



