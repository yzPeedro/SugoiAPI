<?php

namespace App\Tests\Unit\Traits;

use App\Support\Traits\HandleProviders;
use PHPUnit\Framework\TestCase;

class HandleProvidersTest extends TestCase
{
    use HandleProviders;

    public function testIsRegisteredMethodWorksAsExpected(): void
    {
        $this->assertFalse(
            $this->isProviderRegistered('fake-provider')
        );
    }
}
