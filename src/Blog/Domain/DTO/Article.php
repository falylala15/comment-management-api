<?php

namespace Blog\Domain\DTO;

use Blog\Domain\Model\Article as ArticleEntity;

final class Article
{
    private string $id;
    private string $title;
    private string $content;

    private function __construct()
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public static function fromEntity(ArticleEntity $entity): self
    {
        $article = new self();

        $article->id = $entity->getId()->toString();
        $article->content = $entity->getContent();
        $article->title = $entity->getTitle();

        return $article;
    }
}
