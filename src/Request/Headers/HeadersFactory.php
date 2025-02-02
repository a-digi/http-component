<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Headers;

final readonly class HeadersFactory
{
    public static function create(): HeadersBag
    {
        $headersBag = new HeadersBag();
        $headers = getallheaders();

        if (0 === count($headers)) {
            return $headersBag;
        }

        foreach (getallheaders() as $key => $value) {
            $headersBag->add(new Header($key, $value));
        }

        return $headersBag;
    }
}
