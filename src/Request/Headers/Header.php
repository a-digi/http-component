<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Headers;

final readonly class Header
{
    public function __construct(private string $key, private string $value)
    {
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
