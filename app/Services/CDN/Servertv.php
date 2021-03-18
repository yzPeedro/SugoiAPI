<?php

namespace App\Services\CDN;

class Servertv
{
    private static $data = [
        "name" => "Servertv",
        "url"  => "https://servertv001.com"
    ];

    public static function mountURLSeach(array $data): array
    {
        $urls = [];

        $url = self::$data["url"];

        $data["fc"] = strtolower($data["fc"]);

        array_push(
            $urls, 
            $url . "/animes/" . $data["fc"] . "/" . $data["name"] . "/" . $data["epi"]. ".mp4"
        );
        array_push(
            $urls, 
            $url . "/animes/" . $data["fc"] . "/" . $data["name"] . "-dublado/" . $data["epi"]. ".mp4"
        );
        array_push(
            $urls, 
            $url . "/animes/" . $data["fc"] . "/" . $data["name"] . "-legendado/" . $data["epi"]. ".mp4"
        );

        return $urls;
    }

    public static function getDataService(): array
    {
        return self::$data;
    }
}