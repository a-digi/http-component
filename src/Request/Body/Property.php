<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Body;

final readonly class Property
{
    public function __construct(private string|int $key, private string|int|array $value)
    {
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function toInt(): int
    {
        return (int) $this->value;
    }

    public function getValue(): string|int|array
    {
        return $this->value;
    }

    public function key(): string|int
    {
        return $this->key;
    }
}
