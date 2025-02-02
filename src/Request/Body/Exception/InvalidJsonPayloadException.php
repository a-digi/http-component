<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Body\Exception;

final class InvalidJsonPayloadException extends \InvalidArgumentException
{
    public function __construct()
    {
        parent::__construct('Request body: Invalid JSON payload');
    }
}
