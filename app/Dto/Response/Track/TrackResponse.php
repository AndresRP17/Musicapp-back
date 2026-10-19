<?php

namespace App\Dto\Response\Track;


final readonly class TrackResponse {
      public function __construct(
        public ?int $id,
        public int $idAlbum,
        public string $name,
        public string $duration,
        public string $url,
        public int $orden

    ){}

}