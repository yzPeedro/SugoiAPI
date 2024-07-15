<?php

namespace App\Providers\Contracts;

use Psr\Http\Message\ResponseInterface;

interface HandleResponseInterface
{
    public function handleResponse(ResponseInterface $response): string;
}
