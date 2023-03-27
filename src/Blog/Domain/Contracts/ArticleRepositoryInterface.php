<?php

namespace Blog\Domain\Contracts;

use Blog\Domain\Model\Article;
use Blog\Domain\ValueObject\ArticleId;

interface ArticleRepositoryInterface
{
    public function getById(ArticleId $id): Article;

    /**
     * @return array<Article>
     */
    public function getAll(): array;
    public function save(Article $entity): void;
}
