<?php

namespace Blog\Domain\Contracts;

use Blog\Domain\Model\Comment;
use Blog\Domain\ValueObject\ArticleId;

interface CommentRepositoryInterface
{
    /**
     * @phpstan-ignore-next-line
     */
    public function getAll(?ArticleId $id = null): array;
    public function save(Comment $entity): void;
}
