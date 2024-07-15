<?php

namespace App\Tests\Unit\Support;

use App\Support\ResponseSupport;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;

class ResponseSupportTest extends TestCase
{
    /** @test */
    public function itMustThrownExceptionWhenTryingReturnProviderDataFromANonRegisteredProvider(): void
    {
        $this->expectException(\Throwable::class);
        ResponseSupport::providerData('non-registered-provider', []);
    }

    /** @test */
    public function itMustNotReturnDataWhenJsonHasError(): void
    {
        $response = ResponseSupport::json([], Response::HTTP_BAD_REQUEST);
        $this->assertArrayNotHasKey('data', json_decode($response->getContent(), true));
    }

    /** @test */
    public function itMustReturnJsonAsExpected(): void
    {
        $response = ResponseSupport::json(['data' => true], Response::HTTP_OK);
        $this->assertJson($response->getContent());
    }
}
