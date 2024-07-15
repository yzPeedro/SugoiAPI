<?php

namespace App\Providers\Contracts;

interface MediaProviderInterface
{
    public function searchEpisode(int $episodeNumber, int $season, string $slug): array;
}
