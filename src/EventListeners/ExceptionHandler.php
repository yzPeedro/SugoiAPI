<?php

namespace App\EventListeners;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionHandler
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $response = new JsonResponse();

        if ($exception instanceof HttpExceptionInterface) {
            $response->setData([
                'error' => true,
                'message' => $exception->getMessage(),
                'status' => $exception->getStatusCode(),
            ]);
        } else {
            $isDevelopment = 'dev' === $_ENV['APP_ENV'];

            $response->setData([
                'error' => true,
                'message' => $isDevelopment ? [
                    'message' => $exception->getMessage(),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTrace(),
                ] : 'An unexpected error occurred.',
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ]);
        }

        $event->setResponse($response);
    }
}
