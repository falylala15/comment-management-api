<?php

namespace Tests\Infrastructure\Doctrine\Persistence\Repository;

use Blog\Domain\Contracts\ArticleRepositoryInterface;
use Blog\Domain\Contracts\CommentRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Tests\BaseTest;

abstract class AbstractRepositoryTest extends BaseTest
{
    protected Connection $connection;

    /** @phpstan-ignore-next-line  */
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        # See https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
        $this->connection = DriverManager::getConnection([
            // same as DATABASE_URL .env.test
            'url' => "postgresql://app:!ChangeMe!@127.0.0.1:5432/blog_test?serverVersion=15&charset=utf8",
            'driver' => 'pdo_pgsql',
        ]);

        $this->repository = $this->createRepository();
    }

    abstract protected function createRepository(): ArticleRepositoryInterface|CommentRepositoryInterface;

    public function tearDown(): void
    {
        parent::tearDown();
        $this->connection->close();
    }
}
