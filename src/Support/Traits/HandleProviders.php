<?php

namespace App\Support\Traits;

use App\Kernel;
use App\Providers\Contracts\MediaProviderInterface;
use App\Support\Media;

trait HandleProviders
{
    private function serializeProviderName(string $providerName): string
    {
        return str_replace([' ', '-'], '', strtolower($providerName));
    }

    /**
     * Check if a provider is registered.
     */
    public function isProviderRegistered(string $providerName): bool
    {
        return in_array($this->serializeProviderName($providerName), array_keys(Kernel::PROVIDERS));
    }

    /**
     * Get all media providers.
     *
     * @return array{provider: string, instance: MediaProviderInterface}
     */
    public function getAllProviders(): array
    {
        return array_map(function ($provider) {
            return [
                'provider' => $provider,
                'instance' => new $provider(),
            ];
        }, Kernel::PROVIDERS);
    }

    /**
     * Get a media provider.
     */
    public function getProvider(string $providerName): MediaProviderInterface
    {
        $providerClass = Kernel::PROVIDERS[$this->serializeProviderName($providerName)];

        return new $providerClass();
    }
}
