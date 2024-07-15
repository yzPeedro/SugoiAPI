<?php

namespace App\Support\Traits;

use App\Exceptions\ProviderNotRegisteredException;
use Symfony\Component\HttpFoundation\Request;

trait HandleRequest
{
    use HandleProviders;

    private Request $request;

    public function __construct()
    {
        $this->request = Request::createFromGlobals();
    }

    public function parameter(string $name): mixed
    {
        return $this->request->query->get($name);
    }

    public function ignoreOnFail(): bool
    {
        return true == $this->request->query->getBoolean('ignore_on_fail', false);
    }

    public function specificProvider(): string|false
    {
        if ($this->request->query->has('provider') && !$this->isProviderRegistered($this->request->query->get('provider'))) {
            throw new ProviderNotRegisteredException("Provider {$this->request->query->get('provider')} is not registered.");
        }

        return $this->request->query->get('provider', false);
    }

    public function mustUsePrefixes(): bool
    {
        return true == $this->request->query->getBoolean('use_prefixes', false);
    }

    public function mustUseSuffixes(): bool
    {
        return true == $this->request->query->getBoolean('use_suffixes', false);
    }
}
