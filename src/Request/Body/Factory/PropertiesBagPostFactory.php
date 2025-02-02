<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Body\Factory;

use AriAva\Http\Request\Body\PropertiesBag;
use AriAva\Http\Request\RequestMethod;

final readonly class PropertiesBagPostFactory implements PropertiesFactoryInterface
{
    public function __construct(private PropertiesFactory $propertiesFactory, private PropertiesFactoryInterface $nextHandler)
    {
    }

    public function handle(RequestMethod $requestMethod): PropertiesBag
    {
        if (!$requestMethod->isAllowedMethod()) {
            return $this->nextHandler->handle($requestMethod);
        }

        if (0 === count($_POST)) {
            return $this->nextHandler->handle($requestMethod);
        }

        return $this->propertiesFactory->createFrom($_POST);
    }
}
