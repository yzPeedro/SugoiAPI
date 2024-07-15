<?php

namespace App\Providers;

use App\Providers\Contracts\HandleResponseInterface;
use App\Providers\Contracts\MediaProviderInterface;
use App\Providers\Contracts\MediaProviderPropertiesInterface;
use App\Providers\Contracts\MediaProviderRulesInterface;
use App\Support\Traits\SearchEngine;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class AnimesOnlineCCProvider implements MediaProviderInterface, MediaProviderPropertiesInterface, MediaProviderRulesInterface, HandleResponseInterface
{
    use SearchEngine;

    public const BASE_URL = 'https://animesonlinecc.to/episodio/';

    public function isEmbed(): bool
    {
        return true;
    }

    public function hasAds(): bool
    {
        return false;
    }

    public function name(): string
    {
        return 'Animes Online CC';
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
        return $this->baseUrl().$slug.'-episodio-'.$episode;
    }

    public function searchEpisode(int $episodeNumber, int $season, string $slug): array
    {
        return $this->search($episodeNumber, $season, $slug);
    }

    public function canUsePrefix(): bool
    {
        return true;
    }

    public function canUserSuffix(): bool
    {
        return true;
    }

    public function responseHasError(ResponseInterface $response): bool
    {
        return Response::HTTP_NOT_FOUND === $response->getStatusCode();
    }

    public function mustSerializeEpisode(): bool
    {
        return false;
    }

    public function mustHandleResponse(): bool
    {
        return true;
    }

    public function handleResponse(ResponseInterface $response): string
    {
        preg_match('#<iframe.*?src="(.*?)".*?></iframe>#is', $response->getBody()->getContents(), $matches);

        return $matches[1];
    }

    public function slug(): string
    {
        return 'animes-online-cc';
    }
}
