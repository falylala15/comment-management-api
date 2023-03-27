<?php

namespace Blog\Infrastructure\Persistence\Doctrine\Repository;

use Blog\Domain\Contracts\ArticleRepositoryInterface;
use Blog\Domain\DTO\Article;
use Blog\Domain\Factory\ArticleFactory;
use Blog\Domain\Model\Article as ArticleEntity;
use Blog\Domain\ValueObject\ArticleId;
use Doctrine\DBAL\Connection;

final class ArticleRepository implements ArticleRepositoryInterface
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function save(ArticleEntity $article): void
    {
        $this->connection->insert(
            'article',
            $article->toArray()
        );
    }

    public function getById(ArticleId $id): ArticleEntity
    {
        $record = $this->connection->createQueryBuilder()
            ->select('a.*')
            ->from('article', 'a')
            ->where('a.id = :identifier')
            ->setParameter('identifier', $id->toString())
            ->fetchAssociative();

        if (false === $record) {
            throw new \RuntimeException(sprintf('article %s not found.', $id->toString()));
        }

        return ArticleFactory::fromDatabaseRecord($record);
    }

    /**
     * @return array|ArticleEntity[]
     */
    public function getAll(): array
    {
        $records = $this->connection
            ->createQueryBuilder()
            ->select('a.*')
            ->from('article', 'a')
            ->fetchAllAssociative();

        return \array_map([ArticleFactory::class, 'fromDatabaseRecord'], $records);
    }
}
