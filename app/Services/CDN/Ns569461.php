<?php

namespace App\Services\CDN;

class Ns569461
{
    private static $data = [
        "name" => "Ns569461",
        "url"  => "https://ns569461.ip-51-79-82.net"
    ];

    public static function mountURLSeach(array $data): array
    {
        $urls = [];

        $url = self::$data["url"];

        array_push(
            $urls,
            $url . "/" . $data["fc"] . "/" . $data["name"] . "/" . $data["epi"]. ".mp4"
        );

        array_push(
            $urls,
            $url . "/" . $data["fc"] . "/" . $data["name"] . "-legendado/" . $data["epi"]. ".mp4"
        );

        array_push(
            $urls,
            $url . "/" . $data["fc"] . "/" . $data["name"] . "-dublado/" . $data["epi"]. ".mp4"
        );

        return $urls;
    }

    public static function getDataService(): array
    {
        return self::$data;
    }
}