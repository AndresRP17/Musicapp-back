<?php
 
namespace App\Converter\Album;
 
use App\Entity\Albums\Album;
 
final class PrimitiveToAlbumConverter{
    public function convert(array $primitive): Album
    {
        return new Album(
            $primitive['id'],
            $primitive['name'],
            $primitive['artist'],
            $primitive['portada_url'],
            $primitive['description'],
            $primitive['genre'],
            $primitive['creado_en']
        );
    }
}