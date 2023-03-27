<?php

namespace Blog\Application\Command\Comment;

use Blog\Domain\ValueObject\ArticleId;

final class CommentCommand
{
    public function __construct(
        private ?string $articleId,
        private ?string $content,
    ) {
    }

    public function getArticleId(): ArticleId
    {
        return ArticleId::fromString($this->articleId);
    }

    public function getContent(): ?string
    {
        return $this->content;
    }
}
