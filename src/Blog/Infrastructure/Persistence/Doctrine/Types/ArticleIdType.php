<?php

namespace Blog\Infrastructure\Persistence\Doctrine\Types;

use Blog\Domain\ValueObject\ArticleId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class ArticleIdType extends StringType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }
        return (string)$value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?ArticleId
    {
        if (null === $value) {
            return null;
        }

        return ArticleId::fromString($value);
    }
}
