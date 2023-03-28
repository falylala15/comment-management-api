<?php

namespace Blog\Application\DTO;

use Blog\Domain\Model\Comment as CommentEntity;

final class Comment
{
    private string $id;
    private string $content;
    private string $createdAt;
    private string $articleId;

    public function getArticleId(): string
    {
        return $this->articleId;
    }

    private function __construct()
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public static function fromEntity(CommentEntity $entity): self
    {
        $comment = new self();

        $comment->id = $entity->getId()->toString();
        $comment->content = $entity->getContent();
        $comment->createdAt = $entity->getCreatedAt()->format('Y-m-d H:i:s');
        $comment->articleId = $entity->getArticle()->toString();

        return $comment;
    }
}
