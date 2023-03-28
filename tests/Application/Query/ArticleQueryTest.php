<?php

namespace Blog\Application\Query;

use Blog\Domain\Factory\ArticleFactory;
use Blog\Domain\ValueObject\ArticleId;
use Blog\Application\DTO\Article;
use Tests\BaseTest;
use Tests\Infrastructure\Doctrine\Persistence\Doubles\InMemoryArticleRepository;

class ArticleQueryTest extends BaseTest
{
    /**
     * @test
     */
    public function it_should_get_one_article(): void
    {
        $articleRepository = new InMemoryArticleRepository();
        $articleId = $this->faker->uuid();
        $articleRepository->save(ArticleFactory::create(ArticleId::fromString($articleId), $this->faker->text(), $this->faker->text()));

        $articleQuery = new ArticleQuery($articleRepository);
        $article = $articleQuery->getOne($articleId);

        $this->assertInstanceOf(Article::class, $article);
        $this->assertSame($articleId, $article->getId());
    }

    /**
     * @test
     */
    public function it_should_fetch_all_article(): void
    {
        $articleRepository = new InMemoryArticleRepository();

        for ($i = 1; $i <= 3 ; $i++) {
            $articleRepository->save(ArticleFactory::create(ArticleId::fromString($this->faker->uuid()), $this->faker->text(), $this->faker->text()));
        }

        $articleQuery = new ArticleQuery($articleRepository);
        $articles = $articleQuery->fetchAll();

        $this->assertCount(3, $articles);
    }
}
