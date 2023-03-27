<?php

namespace Blog\Domain\Factory;

use Blog\Domain\Model\Article;
use Blog\Domain\ValueObject\ArticleId;

final class ArticleFactory
{
    public static function create(ArticleId $id, string $title, string $content): Article
    {
        return new Article($id, $title, $content);
    }

    /**
     * @param array<string> $record
     */
    public static function fromDatabaseRecord(array $record): Article
    {
        return new Article(
            ArticleId::fromString($record['id']),
            $record['title'],
            $record['content'],
        );
    }
}
