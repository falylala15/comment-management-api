<?php

namespace Blog\Domain\ValueObject;

final class Email implements StringableInterface
{
    private string $value;

    public function __construct(string $value)
    {
        if (false === filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('The email <%s> is not valid', $value));
        }
        $this->value = $value;
    }

    public static function fromString(string $value): Email
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->toString();
    }

    public function toString(): string
    {
        return $this->value;
    }
}
