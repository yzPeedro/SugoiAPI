<?php

namespace App\Support;

use App\Exceptions\ProviderNotRegisteredException;
use App\Support\Traits\HandleProviders;
use Symfony\Component\HttpFoundation\Response;

class ResponseSupport
{
    use HandleProviders;

    /**
     * Return a new response from the application.
     */
    public static function json(array $data = [], int $status = 200): Response
    {
        $hasError = $status >= Response::HTTP_BAD_REQUEST;
        $response = [
            'error' => $hasError,
            'message' => $hasError ? 'An error occurred' : 'Success',
            'status' => $status,
        ];

        if (!$hasError) {
            $response['data'] = $data;
        }

        return new Response(json_encode($response), $status, [
            'Content-Type' => 'application/json',
        ]);
    }

    /**
     * @return array{provider: string, data: array}
     *
     * @throws ProviderNotRegisteredException
     */
    public static function providerData(string $providerName, array $data): array
    {
        if (!(new ResponseSupport())->isProviderRegistered($providerName)) {
            throw new ("The Provider $providerName is not registered. please add the provider to the Kernel::PROVIDERS array.");
        }

        $provider = (new ResponseSupport())->getProvider($providerName);

        return [
            'name' => $provider->name(),
            'slug' => $provider->slug(),
            'has_ads' => $provider->hasAds(),
            'is_embed' => $provider->isEmbed(),
            'episodes' => $data,
        ];
    }
}
