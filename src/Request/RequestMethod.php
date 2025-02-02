<?php

declare(strict_types=1);

namespace AriAva\Http\Request;

enum RequestMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case PATCH = 'PATCH';

    case OPTIONS = 'OPTIONS';

    public function isGet(): bool
    {
        return match ($this) {
            self::GET => true,
            default => false
        };
    }

    public function isDelete(): bool
    {
        return match ($this) {
            self::DELETE => true,
            default => false
        };
    }

    public function isAllowedMethod(): bool
    {
        return match ($this) {
            RequestMethod::OPTIONS,
            RequestMethod::PATCH,
            RequestMethod::POST,
            RequestMethod::DELETE,
            RequestMethod::PUT => true,
            default => false,
        };
    }
}
