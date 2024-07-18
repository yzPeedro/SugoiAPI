<?php

namespace App\Tests\Unit\Providers;

use App\Kernel;
use App\Providers\Contracts\MediaProviderInterface;
use App\Providers\Contracts\MediaProviderPropertiesInterface;
use App\Providers\Contracts\MediaProviderRulesInterface;
use App\Support\Traits\WithInterfaces;
use PHPUnit\Framework\TestCase;

class ProviderTest extends TestCase
{
    use WithInterfaces;

    public function testProvidersMustImplementsAllRequiredInterfaces(): void
    {
        $providers = Kernel::PROVIDERS;
        foreach ($providers as $provider) {
            $this->assertTrue($this->hasImplementation($provider, MediaProviderInterface::class));
            $this->assertTrue($this->hasImplementation($provider, MediaProviderPropertiesInterface::class));
            $this->assertTrue($this->hasImplementation($provider, MediaProviderRulesInterface::class));
        }
    }

    public function testAllProvidersMustBeRegistered(): void
    {
        $classes = $this->getProvidersFromDirectory();
        $providers = Kernel::PROVIDERS;

        sort($providers);
        sort($classes);

        $this->assertEquals($providers, $classes);
    }
}
