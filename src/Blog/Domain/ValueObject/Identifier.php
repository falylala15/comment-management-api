<?php

namespace Blog\Domain\ValueObject;

use Assert\Assertion;
use Ramsey\Uuid\Uuid;

abstract class Identifier implements StringableInterface
{
    final private function __construct(protected string $id)
    {
        Assertion::uuid($id);
    }

    public static function generate(): static
    {
        return new static((Uuid::uuid4())->toString());
    }

    public static function fromString(string $id): static
    {
        return new static($id);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->id;
    }
}
