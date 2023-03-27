<?php

namespace Tests\Infrastructure\Doctrine\Persistence\Doubles;

use Blog\Domain\Contracts\CommentRepositoryInterface;
use Blog\Domain\Model\Comment;
use Blog\Domain\ValueObject\ArticleId;
use Blog\Domain\ValueObject\CommentId;

final class InMemoryCommentRepository implements CommentRepositoryInterface
{
    /**
     * @phpstan-ignore-next-line
     */
    private array $comments = [];

    /**
     * @return array<Comment>
     */
    public function getAll(?ArticleId $id = null): array
    {
        return $this->comments;
    }

    public function save(Comment $comment): void
    {
        $this->comments[$comment->getId()->toString()] = $comment;
    }

    public function getById(CommentId $id): Comment
    {
        return $this->comments[$id->toString()];
    }
}
