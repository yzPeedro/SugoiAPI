<?php

namespace App\Services\CDN;

class Ns569461
{
    private static $data = [
        "name" => "Ns569461",
        "url"  => "https://ns569461.ip-51-79-82.net"
    ];

    public static function mountURLSeach(array $data): string
    {
        $url = self::$data;

        $url .= "/" . $data["fc"] . "/" . $data["animeName"] . "/" . $data["epi"]. ".mp4" ;

        return $url;
    }

    public static function getDataService(): array
    {
        return self::$data;
    }
}