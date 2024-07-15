<?php

namespace App\Providers\Contracts;

interface MediaProviderPropertiesInterface
{
    public function isEmbed(): bool;

    public function hasAds(): bool;

    public function name(): string;

    public function slug(): string;

    public function baseUrl(): string;

    public function searchRequestMethod(): string;

    public function getSearchEpisodeEndpoint(int $episode, int $season, string $slug): string;
}
