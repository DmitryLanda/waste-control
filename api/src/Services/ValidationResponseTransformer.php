<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;
use Throwable;

class ValidationResponseTransformer implements EventSubscriberInterface
{
    public function __construct(private SerializerInterface $serializer)
    {}

    public function onKernelException(ExceptionEvent $event) {
        $exception = $event->getThrowable();
        if (!$this->supports($exception)) {
            return;
        }

        $event->setResponse($this->transformResponse($exception));
    }

    private function supports(Throwable $exception): bool
    {
        return $exception instanceof ValidationException;
    }


    private function transformResponse(Throwable $exception): JsonResponse
    {
        $json = $this->serializer->serialize(
            $exception,
            'json',
            ['json_encode_options' => JsonResponse::DEFAULT_ENCODING_OPTIONS]
        );

        return new JsonResponse($json, JsonResponse::HTTP_UNPROCESSABLE_ENTITY, [], true);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onKernelException'],
            ],
        ];
    }
}