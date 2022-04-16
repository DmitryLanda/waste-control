<?php

declare(strict_types=1);

namespace App\System\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        // return the subscribed events, their methods and priorities
        return [
            KernelEvents::EXCEPTION => [
                ['convertIntoJsonResponse', 1000],
            ],
        ];
    }

    public function convertIntoJsonResponse(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        $content = [
            'message' => $exception->getMessage(),
        ];
        $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

        switch (true) {
            case $exception instanceof HttpException:
                $statusCode = $exception->getStatusCode();
                break;
            case $exception instanceof NotNormalizableValueException:
                $content = [
                    'property' => $exception->getPath(),
                    'message'  => sprintf(
                        'Expected type "%s" but got "%s"',
                        $exception->getExpectedTypes()[0],
                        $exception->getCurrentType()
                    ),
                ];
                $statusCode = Response::HTTP_BAD_REQUEST;
                break;
            case $exception instanceof NotEncodableValueException:
                $content = [
                    'property' => null,
                    'message'  => 'Request is malformed',
                ];
                $statusCode = Response::HTTP_BAD_REQUEST;
                break;
        }

        $event->setResponse(new JsonResponse($content, $statusCode));
    }
}