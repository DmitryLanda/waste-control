<?php

declare(strict_types=1);

namespace App\System\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class QueryConverter implements ParamConverterInterface
{
    private const NAME = 'query_converter';

    public function __construct(private DenormalizerInterface $denormalizer)
    {
    }

    public function apply(Request $request, ParamConverter $configuration): void
    {
        $data = $request->query->all();
        $dto = $this->denormalizer->denormalize($data, $configuration->getClass());

        $request->attributes->set($configuration->getName(), $dto);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getConverter() === self::NAME;
    }
}