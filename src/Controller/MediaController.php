<?php

namespace App\Controller;

use App\Exceptions\ProviderNotRegisteredException;
use App\Services\MediaService;
use App\Support\ResponseSupport;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MediaController
{
    private MediaService $mediaService;

    public function __construct()
    {
        $this->mediaService = new MediaService();
    }

    /**
     * Display a list of episodes.
     *
     * @return string
     *
     * @throws ProviderNotRegisteredException
     */
    #[Route('/episode/{slug}/{season}/{episodeNumber}', name: 'episodes', methods: ['GET'])]
    public function episode(string $slug, int $season, int $episodeNumber): Response
    {
        return ResponseSupport::json(
            $this->mediaService->searchEpisode($episodeNumber, $season, $slug)
        );
    }
}
