<?php

namespace App\Support\Traits;

use App\Actions\Providers\SerializeEpisodeAction;
use App\Support\Media;
use GuzzleHttp\Client;

trait SearchEngine
{
    use HandleRequest;

    public function getAllSearchPromises(int $episodeNumber, int $season, string $slug): array
    {
        if ($this->mustSerializeEpisode()) {
            $episodeNumber = SerializeEpisodeAction::run($episodeNumber);
        }

        $endpoints = [
            $this->getSearchEpisodeEndpoint($episodeNumber, $season, $slug),
        ];

        if (!$this->canUsePrefix() && !$this->canUserSuffix()) {
            return $endpoints;
        }

        if ($this->canUsePrefix() && $this->mustUsePrefixes()) {
            foreach (Media::COMMON_PREFIXES as $prefix) {
                $endpoints[] = $this->getSearchEpisodeEndpoint($episodeNumber, $season, "$prefix-$slug");
            }
        }

        if ($this->canUserSuffix() && $this->mustUseSuffixes()) {
            foreach (Media::COMMON_SUFFIXES as $suffix) {
                $endpoints[] = $this->getSearchEpisodeEndpoint($episodeNumber, $season, "$slug-$suffix");
            }
        }

        return $endpoints;
    }

    /**
     * @throws \Throwable
     */
    public function search(int $episodeNumber, int $season, string $slug): array
    {
        $response = [];
        $endpoints = $this->getAllSearchPromises($episodeNumber, $season, $slug);

        foreach ($endpoints as $endpoint) {
            try {
                $client = new Client(['base_uri' => $this->baseUrl()]);
                $promiseResponse = $client->request($this->searchRequestMethod(), $endpoint);

                $response[] = match (true) {
                    $this->responseHasError($promiseResponse) && !$this->ignoreOnFail() => [
                        'error' => true,
                        'searched_endpoint' => $endpoint,
                        'episode' => null,
                    ],
                    $this->mustHandleResponse() => [
                        'error' => false,
                        'searched_endpoint' => $endpoint,
                        'episode' => $this->handleResponse($promiseResponse),
                    ],
                    default => [
                        'error' => false,
                        'searched_endpoint' => $endpoint,
                        'episode' => $endpoint,
                    ],
                };
            } catch (\Throwable) {
                if (!$this->ignoreOnFail()) {
                    $response[] = [
                        'error' => true,
                        'searched_endpoint' => $endpoint,
                        'episode' => null,
                    ];
                }
            }
        }

        return $response;
    }
}
