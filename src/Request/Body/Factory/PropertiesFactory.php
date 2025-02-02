<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Body\Factory;

use AriAva\Http\Request\Body\PropertiesBag;
use AriAva\Http\Request\Body\Property;

class PropertiesFactory
{
    public function createFrom(array $properties): PropertiesBag
    {
        $propertiesBag = new PropertiesBag();

        if (0 === count($properties)) {
            return $propertiesBag;
        }

        foreach ($properties as $key => $propertyValue) {
            $propertiesBag->add(new Property($key, $propertyValue ?? ''));
        }

        return $propertiesBag;
    }
}
