<?php

namespace Blog\Domain\Model;

use Blog\Domain\ValueObject\ArticleId;
use Blog\Domain\ValueObject\CommentId;
use Blog\Domain\ValueObject\Email;

final class Comment
{
    private \DateTimeImmutable $createdAt;

    public function __construct(
        private CommentId $id,
        private ArticleId $article,
        private string $content,
        private Email $author
    ) {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): CommentId
    {
        return $this->id;
    }

    public function getAuthor(): Email
    {
        return $this->author;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getArticle(): ArticleId
    {
        return $this->article;
    }

    public function setArticle(ArticleId $article): self
    {
        $this->article = $article;

        return $this;
    }
}
