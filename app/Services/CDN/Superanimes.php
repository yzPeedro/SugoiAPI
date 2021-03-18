<?php

namespace App\Services\CDN;

class Superanimes
{
    private static $data = [
        "name" => "Superanimes",
        "url"  => "https://cdn.superanimes.tv"
    ];

    public static function mountURLSeach(array $data): array
    {
        $urls = [];

        $url = self::$data["url"];

        $data["fc"] = strtolower($data["fc"]);

        array_push(
            $urls, 
            $url . "/010/animes/" . $data["fc"] . "/" . $data["name"] . "/" . $data["epi"]. ".mp4"
        );
        array_push(
            $urls, 
            $url . "/010/animes/" . $data["fc"] . "/" . $data["name"] . "-dublado/" . $data["epi"]. ".mp4"
        );
        array_push(
            $urls, 
            $url . "/010/animes/" . $data["fc"] . "/" . $data["name"] . "-legendado/" . $data["epi"]. ".mp4"
        );

        return $urls;
    }

    public static function getDataService(): array
    {
        return self::$data;
    }
}