<?php

declare(strict_types=1);

namespace AriAva\Http\Request\Body;

use AriAva\Http\Request\Body\Exception\PropertyNotExistsException;
use Traversable;

final class PropertiesBag implements \Countable, \IteratorAggregate
{
    public function __construct(private array $properties = [])
    {
    }

    public function add(Property $property): void
    {
        if ($this->has($property->key())) {
            return;
        }

        $this->properties[$property->key()] = $property;
    }

    public function has(string|int $key): bool
    {
        return array_key_exists($key, $this->properties);
    }

    /**
     * @throws PropertyNotExistsException
     */
    public function get(string $key): Property
    {
        if (!$this->has($key)) {
            throw new PropertyNotExistsException($key);
        }

        return $this->properties[$key];
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->properties);
    }

    public function count(): int
    {
        return count($this->properties);
    }
}
