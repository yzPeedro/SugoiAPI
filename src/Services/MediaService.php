<?php

namespace App\Services;

use App\Exceptions\MediaNotFoundException;
use App\Exceptions\ProviderNotRegisteredException;
use App\Support\ResponseSupport;
use App\Support\Traits\HandleProviders;
use App\Support\Traits\HandleRequest;

class MediaService
{
    use HandleProviders;
    use HandleRequest;

    private function getValidProvider(): array
    {
        if (!$this->specificProvider()) {
            return $this->getAllProviders();
        }

        return [[
            'instance' => $this->getProvider($this->parameter('provider')),
        ]];
    }

    /**
     * Search for an episode.
     *
     * @throws ProviderNotRegisteredException
     */
    public function searchEpisode(int $episodeNumber, int $season, string $slug): array
    {
        $providers = $this->getValidProvider();
        $searchResult = [];

        foreach ($providers as $provider) {
            $episodes = $provider['instance']->searchEpisode($episodeNumber, $season, $slug);

            if (empty($episodes)) {
                continue;
            }

            $searchResult[] = ResponseSupport::providerData(
                $provider['instance']->name(),
                $episodes
            );
        }

        $errors = [];
        $countEpisodes = 0;

        foreach ($searchResult as $result) {
            $foundedErrors = array_filter($result['episodes'], fn ($episode) => true == $episode['error']);

            if ($foundedErrors) {
                $errors[] = $result;
            }

            $countEpisodes += count($result['episodes']);
        }

        if (!empty($errors) && count($errors) == $countEpisodes) {
            throw new MediaNotFoundException(message: 'Not Found');
        }

        return $searchResult;
    }
}
