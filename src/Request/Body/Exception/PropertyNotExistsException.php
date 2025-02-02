<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Body\Exception;

final class PropertyNotExistsException extends \Exception
{
    public function __construct(string $property)
    {
        parent::__construct('Property ' . $property . ' does not exist.');
    }
}
