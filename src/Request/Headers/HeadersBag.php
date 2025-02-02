<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Headers;

use Countable;
use Traversable;

final class HeadersBag implements \IteratorAggregate, Countable
{
    public function __construct(private array $headers = [])
    {
    }

    public function add(Header $header): void
    {
        if (array_key_exists($header->getKey(), $this->headers)) {
            return;
        }

        $this->headers[$header->getKey()] = $header;
    }

    public function get(string $key, $defaultValue = null): Header|null
    {
        if (array_key_exists($key, $this->headers)) {
            return $this->headers[$key];
        }

        if (null === $defaultValue) {
            return null;
        }

        return new Header($key, $defaultValue);
    }

    public function toArray(): array
    {
        return $this->headers;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->headers);
    }

    public function remove(string $key): void
    {
        if (!$this->has($key)) {
            return;
        }

        unset($this->headers[$key]);
    }

    public function removeAll(): void
    {
        $this->headers = [];
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->headers);
    }

    public function count(): int
    {
        return count($this->headers);
    }
}
