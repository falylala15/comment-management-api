<?php

namespace Blog\Domain\Factory;

use Blog\Domain\Model\Comment;
use Blog\Domain\ValueObject\ArticleId;
use Blog\Domain\ValueObject\CommentId;
use Blog\Domain\ValueObject\Email;

final class CommentFactory
{
    public static function create(CommentId $id, ArticleId $article, string $content, Email $author): Comment
    {
        return new Comment($id, $article, $content, $author);
    }

    /**
     * @param array<string> $record
     */
    public static function fromDatabaseRecord(array $record): Comment
    {
        return new Comment(
            CommentId::fromString($record['id']),
            ArticleId::fromString($record['article_id']),
            $record['content'],
            Email::fromString($record['author'])
        );
    }
}
