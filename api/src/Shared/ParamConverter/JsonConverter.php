<?php

namespace App\Shared\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Exception\NotNormalizableValueException;
use Symfony\Component\Serializer\SerializerInterface;

class JsonConverter implements ParamConverterInterface
{
    private const NAME = 'json_converter';

    public function __construct(private SerializerInterface $serializer)
    {}

    public function apply(Request $request, ParamConverter $configuration)
    {
        $data = $request->getContent();
        $dto = $this->serializer->deserialize($data, $configuration->getClass(), 'json');

        $request->attributes->set($configuration->getName(), $dto);
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return bool
     */
    public function supports(ParamConverter $configuration): bool
    {
        return $configuration->getConverter() === self::NAME;
    }
}