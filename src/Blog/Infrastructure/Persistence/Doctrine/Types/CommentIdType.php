<?php

namespace Blog\Infrastructure\Persistence\Doctrine\Types;

use Blog\Domain\ValueObject\CommentId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class CommentIdType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }
        return $value->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?CommentId
    {
        if (null === $value) {
            return null;
        }

        return CommentId::fromString($value);
    }
}
