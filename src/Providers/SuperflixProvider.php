<?php

namespace App\Providers;

use App\Providers\Contracts\MediaProviderInterface;
use App\Providers\Contracts\MediaProviderPropertiesInterface;
use App\Providers\Contracts\MediaProviderRulesInterface;
use App\Support\Traits\SearchEngine;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class SuperflixProvider implements MediaProviderInterface, MediaProviderPropertiesInterface, MediaProviderRulesInterface
{
    use SearchEngine;

    public const BASE_URL = 'https://superflixapi.top/serie/';

    public const SUCCESS_SIZE_RESPONSE = 262715;

    /**
     * @throws GuzzleException
     */
    public function searchEpisode(int $episodeNumber, int $season, string $slug): array
    {
        return $this->search($episodeNumber, $season, $slug);
    }

    public function isEmbed(): bool
    {
        return true;
    }

    public function hasAds(): bool
    {
        return true;
    }

    public function name(): string
    {
        return 'Superflix';
    }

    public function baseUrl(): string
    {
        return self::BASE_URL;
    }

    public function searchRequestMethod(): string
    {
        return 'GET';
    }

    public function getSearchEpisodeEndpoint(int $episode, int $season, string $slug): string
    {
        return $this->baseUrl().$slug."/$season/".$episode;
    }

    public function canUsePrefix(): bool
    {
        return false;
    }

    public function canUserSuffix(): bool
    {
        return false;
    }

    public function responseHasError(ResponseInterface $response): bool
    {
        return $response->getBody()->getSize() < self::SUCCESS_SIZE_RESPONSE;
    }

    public function mustSerializeEpisode(): bool
    {
        return false;
    }

    public function mustHandleResponse(): bool
    {
        return true;
    }

    public function slug(): string
    {
        return 'superflix';
    }
}
