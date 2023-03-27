<?php

namespace Tests\Domain\Model;

use Blog\Domain\Factory\ArticleFactory;
use Blog\Domain\ValueObject\ArticleId;
use Tests\BaseTest;

class ArticleTest extends BaseTest
{
    /**
     * @test
     */
    public function it_will_create_an_article(): void
    {
        $articleId = ArticleId::generate();
        $title = $this->faker->title();
        $content = $this->faker->text(50);

        $article = ArticleFactory::create($articleId, $title, $content);

        $this->assertSame($articleId, $article->getId());
        $this->assertSame($title, $article->getTitle());
        $this->assertSame($content, $article->getContent());
    }

    /**
     * @test
     */
    public function it_create_an_article_from_database_record(): void
    {
        $record = [
            'id' => $this->faker->uuid(),
            'title' => $this->faker->title(),
            'content' => $this->faker->text(50)
        ];

        $article = ArticleFactory::fromDatabaseRecord($record);

        $this->assertSame($record['id'], $article->getId()->toString());
        $this->assertSame($record['title'], $article->getTitle());
        $this->assertSame($record['content'], $article->getContent());
    }
}
