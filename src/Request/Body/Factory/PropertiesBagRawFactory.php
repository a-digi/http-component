<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Body\Factory;

use AriAva\Http\Request\Body\Exception\InvalidJsonPayloadException;
use AriAva\Http\Request\Body\PropertiesBag;
use AriAva\Http\Request\RequestMethod;
use AriAva\Http\Request\RequestMethodNotAllowedException;

final readonly class PropertiesBagRawFactory implements PropertiesFactoryInterface
{
    public function __construct(private PropertiesFactory $propertiesFactory)
    {
    }

    /**
     * @throws RequestMethodNotAllowedException
     * @throws \JsonException
     */
    public function handle(RequestMethod $requestMethod): PropertiesBag
    {
        if (!$requestMethod->isAllowedMethod()) {
            throw new RequestMethodNotAllowedException($requestMethod->value);
        }

        if ($requestMethod->isDelete()) {
            return $this->propertiesFactory->createFrom([]);
        }

        $jsonData = file_get_contents('php://input');

        if (!json_validate($jsonData)) {
            throw new InvalidJsonPayloadException();
        }

        return $this->propertiesFactory->createFrom(
            json_decode($jsonData, true, 512, JSON_THROW_ON_ERROR)
        );
    }
}
