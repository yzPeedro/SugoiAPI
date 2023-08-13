<?php

namespace App\Services\CDN;

class LightSpeedst
{
    private static $versions = 3;

    private static $data = [
        "name" => "Fluehost",
        "url"  => "https://lightspeedst.net/s{{version}}/mp4/{{name}}/sd/{{epi}}"
    ];

    public static function mountURLSeach(array $data): array
    {
        $urls = [];

        for ($i = 1; $i <= self::$versions; $i++) {
            $url = str_replace(['{{version}}', '{{epi}}'], [$i, $data['epi']], self::$data["url"]) . '.mp4';

            array_push($urls, 
                str_replace(['{{name}}'], $data["name"], $url),
                str_replace(['{{name}}'], $data["name"]. '-dublado.mp4', $url),
            );
        }

        return $urls;
    }
    
    public static function getDataService(): array
    {
        return self::$data;
    }
}