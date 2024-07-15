<?php

namespace App\Providers;

use App\Providers\Contracts\HandleResponseInterface;
use App\Providers\Contracts\MediaProviderInterface;
use App\Providers\Contracts\MediaProviderPropertiesInterface;
use App\Providers\Contracts\MediaProviderRulesInterface;
use App\Support\Traits\SearchEngine;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class AnimeFireProvider implements MediaProviderInterface, MediaProviderPropertiesInterface, MediaProviderRulesInterface, HandleResponseInterface
{
    use SearchEngine;

    public const BASE_URL = 'https://animefire.plus/video/';

    private array $responseData = [];

    public function searchEpisode(int $episodeNumber, int $season, string $slug): array
    {
        return $this->search($episodeNumber, $season, $slug);
    }

    public function isEmbed(): bool
    {
        return false;
    }

    public function hasAds(): bool
    {
        return false;
    }

    public function name(): string
    {
        return 'Anime Fire';
    }

    public function slug(): string
    {
        return 'anime-fire';
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
        return self::BASE_URL.$slug."/$episode";
    }

    public function canUsePrefix(): bool
    {
        return true;
    }

    public function canUserSuffix(): bool
    {
        return true;
    }

    public function mustSerializeEpisode(): bool
    {
        return false;
    }

    public function mustHandleResponse(): bool
    {
        return true;
    }

    public function responseHasError(ResponseInterface $response): bool
    {
        $json = json_decode($response->getBody()->getContents(), true);

        $this->responseData = $json['data'];

        return Response::HTTP_INTERNAL_SERVER_ERROR == $json['response']['status'];
    }

    public function handleResponse(ResponseInterface $response): string
    {
        return $this->responseData[0]['src'];
    }
}
