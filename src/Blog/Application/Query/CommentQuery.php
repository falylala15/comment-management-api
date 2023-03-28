<?php

namespace Blog\Application\Query;

use Blog\Domain\Contracts\CommentRepositoryInterface;
use Blog\Domain\Model\Comment;
use Blog\Domain\ValueObject\ArticleId;
use Blog\Application\DTO\Comment as CommentDTO;

class CommentQuery
{
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
    }

    /**
     * @return array<CommentDTO>
     */
    public function fetchAll(?string $id = null): array
    {
        $comments = $this->commentRepository->getAll(ArticleId::fromString($id));

        return \array_map(function (Comment $comment) {
            return CommentDTO::fromEntity($comment);
        }, $comments);
    }
}
