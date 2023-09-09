<?php

namespace App\Services\CDN;

class LightSpeedst
{
    private const VERSIONS = 3;

    private static array $data = [
        "name" => "Fluehost",
        "url"  => "https://lightspeedst.net/s{{version}}/mp4/{{name}}/sd/{{epi}}"
    ];

    public static function mountURLSearch(array $data): array
    {
        $urls = [];

        for ($i = 1; $i <= self::VERSIONS; $i++) {
            $url = str_replace([
                '{{version}}', '{{epi}}'], [$i, self::removeZero($data['epi'])],
                self::$data["url"]
            ) . '.mp4';

            array_push($urls,
                str_replace(['{{name}}'], $data["name"], $url),
                str_replace(['{{name}}'], $data["name"]. '-dublado', $url),
            );
        }

        return $urls;
    }

    private static function removeZero(string $episode): string
    {
        if ($episode[0] === '0') {
            return $episode[1];
        }

        return $episode;
    }

    public static function getDataService(): array
    {
        return self::$data;
    }
}