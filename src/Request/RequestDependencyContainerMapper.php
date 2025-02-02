<?php

declare(strict_types=1);

namespace AriAva\Http\Request;

use AriAva\Contracts\DependencyInjection\ContainerInterface;
use AriAva\Http\Request\Body\Factory\PropertiesBagGetFactory;
use AriAva\Http\Request\Body\Factory\PropertiesBagPostFactory;
use AriAva\Http\Request\Body\Factory\PropertiesBagRawFactory;
use AriAva\Http\Request\Body\Factory\PropertiesFactory;
use Psr\Http\Message\RequestInterface;

final class RequestDependencyContainerMapper
{
    public static function map(ContainerInterface $container): void
    {
        $container->add(
            RequestInterface::class,
            static function () {
                $requestPropertiesFactory = new PropertiesFactory();
                $requestPropertiesGetFactory = new PropertiesBagGetFactory(
                    $requestPropertiesFactory,
                    new PropertiesBagPostFactory(
                        $requestPropertiesFactory,
                        new PropertiesBagRawFactory(
                            $requestPropertiesFactory
                        )
                    )
                );

                return new Request(
                    $_SERVER,
                    $requestPropertiesGetFactory
                );
            }
        );
    }
}
