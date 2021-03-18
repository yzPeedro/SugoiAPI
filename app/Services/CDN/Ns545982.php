<?php

namespace App\Services\CDN;

class Ns545982
{
    private static $data = [
        "name" => "Ns545982",
        "url"  => "https://ns545982.ip-66-70-177.net"
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