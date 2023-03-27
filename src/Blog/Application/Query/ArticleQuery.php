<?php

namespace Blog\Application\Query;

use Blog\Domain\Contracts\ArticleRepositoryInterface;
use Blog\Domain\DTO\Article as ArticleDTO;
use Blog\Domain\Model\Article;
use Blog\Domain\ValueObject\ArticleId;

class ArticleQuery
{
    public function __construct(private ArticleRepositoryInterface $articleRepository)
    {
    }

    /**
     * @return array<ArticleDTO>
     */
    public function fetchAll(): array
    {
        return \array_map(function (Article $article) {
            return ArticleDTO::fromEntity($article);
        }, $this->articleRepository->getAll());
    }

    public function getOne(string $id): ArticleDTO
    {
        $article = $this->articleRepository->getById(ArticleId::fromString($id));

        return ArticleDTO::fromEntity($article);
    }
}
