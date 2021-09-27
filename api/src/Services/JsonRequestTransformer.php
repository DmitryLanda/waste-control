<?php

namespace App\Services;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonRequestTransformer implements EventSubscriberInterface
{
    public function onKernelRequest(RequestEvent $event) {
        $request = $event->getRequest();
        $content = $request->getContent();
        if (empty($content)) {
            return;
        }

        if (!$this->supports($request)) {
            return;
        }

        if (!$this->transformJsonBody($request)) {
            $response = new JsonResponse([
                'message' => 'Невалидная структура запроса'
            ], JsonResponse::HTTP_BAD_REQUEST);
            $event->setResponse($response);
        }
    }

    private function supports(Request $request): bool
    {
        return 'json' === $request->getContentType();
    }


    private function transformJsonBody(Request $request): bool
    {
        $data = json_decode($request->getContent(), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }
        if ($data === null) {
            return true;
        }
        $request->request->replace($data);

        return true;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [
                ['onKernelRequest'],
            ],
        ];
    }
}