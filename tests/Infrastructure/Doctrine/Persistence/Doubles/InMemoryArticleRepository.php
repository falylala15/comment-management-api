<?php

namespace Tests\Infrastructure\Doctrine\Persistence\Doubles;

use Blog\Domain\Contracts\ArticleRepositoryInterface;
use Blog\Domain\Model\Article;
use Blog\Domain\ValueObject\ArticleId;

final class InMemoryArticleRepository implements ArticleRepositoryInterface
{
    /**
     * @phpstan-ignore-next-line
     */
    private array $articles = [];

    /**
     * @return array<Article>
     */
    public function getAll(): array
    {
        return $this->articles;
    }

    public function save(Article $article): void
    {
        $this->articles[$article->getId()->toString()] = $article;
    }

    public function getById(ArticleId $id): Article
    {
        return $this->articles[$id->toString()];
    }
}
