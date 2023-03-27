<?php

namespace Tests\Infrastructure\Doctrine\Persistence\Repository;

use Blog\Domain\Contracts\ArticleRepositoryInterface;
use Blog\Domain\Model\Article;
use Blog\Domain\Factory\ArticleFactory;
use Blog\Domain\ValueObject\ArticleId;
use Blog\Infrastructure\Persistence\Doctrine\Repository\ArticleRepository;

class ArticleRepositoryTest extends AbstractRepositoryTest
{
    protected function createRepository(): ArticleRepositoryInterface
    {
        return new ArticleRepository($this->connection);
    }

    /**
     * @test
     */
    public function it_should_be_save(): void
    {
        $article = ArticleFactory::create(ArticleId::generate(), $this->faker->text(5), $this->faker->text());

        $this->repository->save($article);

        $articleWasBeenCreated = $this->repository->getById($article->getId());

        $this->assertInstanceOf(Article::class, $articleWasBeenCreated);
        $this->assertSame($article->getId()->toString(), $articleWasBeenCreated->getId()->toString());
        $this->assertSame($article->getTitle(), $articleWasBeenCreated->getTitle());
        $this->assertSame($article->getContent(), $articleWasBeenCreated->getContent());
    }

    /**
     * @test
     */
    public function it_should_get_all_article(): void
    {
        $this->connection->executeStatement('TRUNCATE TABLE article CASCADE');

        $this->assertCount(0, $this->repository->getAll());
    }

    /**
     * @test
     */
    public function it_should_throw_an_exception_get__not_exits_an_article_by_id(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->repository->getById(ArticleId::fromString($this->faker->uuid()));
    }
}
