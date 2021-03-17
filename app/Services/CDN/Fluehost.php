<?php

namespace App\Services\CDN;

class Fluehost
{
    private static $data = [
        "name" => "Fluehost",
        "url"  => "https://cdn02.fluehost.com/"
    ];

    public static function mountURLSeach(array $data): array
    {
        $urls = [];

        $url = self::$data["url"];

        array_push(
            $urls,
            $url . "/a/" . $data["name"] . "/" . $data["epi"]. ".mp4"
        );

        array_push(
            $urls,
            $url . "/a/" . $data["name"] . "-legendado/" . $data["epi"]. ".mp4"
        );

        array_push(
            $urls,
            $url . "/a/" . $data["name"] . "-dublado/" . $data["epi"]. ".mp4"
        );

        return $urls;
    }

    public static function getDataService(): array
    {
        return self::$data;
    }
}