<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Body\Factory;

use AriAva\Http\Request\Body\PropertiesBag;
use AriAva\Http\Request\RequestMethod;

interface PropertiesFactoryInterface
{
    public function handle(RequestMethod $requestMethod): PropertiesBag;
}
