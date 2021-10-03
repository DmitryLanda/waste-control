<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Exceptions\ValidationException;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class AppErrorNormalizer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof AppException && !($data instanceof ValidationException);
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        return [
            'message' => $object->getMessage(),
        ];
    }
}