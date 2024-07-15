<?php

namespace App\Providers\Contracts;

use Psr\Http\Message\ResponseInterface;

interface MediaProviderRulesInterface
{
    public function canUsePrefix(): bool;

    public function canUserSuffix(): bool;

    public function mustSerializeEpisode(): bool;

    public function mustHandleResponse(): bool;

    public function responseHasError(ResponseInterface $response): bool;
}
