<?php

namespace App\Services;

use App\Exceptions\ValidationException;
use Symfony\Component\Form\FormError;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class ValidationErrorNormalizer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return $data instanceof ValidationException;
    }

    public function normalize($object, string $format = null, array $context = []): array
    {
        $errors = [];
        /** @var FormError $error */
        foreach ($object->getErrors() as $error) {
            $key = $error->getOrigin()->getName();
            if (!array_key_exists($key, $errors)) {
                $errors[$key] = [];
            }

            $errors[$key][] = $error->getMessage();
        }

        return [
            'message' => $object->getMessage(),
            'errors' => $errors,
        ];
    }
}