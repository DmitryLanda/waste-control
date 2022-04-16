<?php

declare(strict_types=1);

namespace App\System\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class JsonConverter implements ParamConverterInterface
{
    private const NAME = 'json_converter';

    public function __construct(private SerializerInterface $serializer)
    {
    }

    public function apply(Request $request, ParamConverter $configuration): void
    {
        $data = $request->getContent();
        $dto = $this->serializer->deserialize($data, $configuration->getClass(), 'json');

        $request->attributes->set($configuration->getName(), $dto);
    }

    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getConverter() === self::NAME;
    }
}