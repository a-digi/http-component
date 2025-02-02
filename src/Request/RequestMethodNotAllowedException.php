<?php

declare(strict_types=1);

namespace AriAva\Http\Request;

final class RequestMethodNotAllowedException extends \Exception
{
    public function __construct(string $requestMethod)
    {
        parent::__construct('Request method not allowed: ' . $requestMethod);
    }
}
