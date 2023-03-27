<?php

namespace Tests\Domain\DTO;

use Blog\Domain\Factory\ArticleFactory;
use Tests\BaseTest;

class ArticleTest extends BaseTest
{
    /**
     * @test
     */
    public function it_an_article_can_be_created_from_database_data(): void
    {
        $record = [
            'id' => $this->faker->uuid(),
            'title' => $this->faker->title(),
            'content' => $this->faker->text(50),
        ];

        $article = ArticleFactory::fromDatabaseRecord($record);

        $this->assertSame($record['id'], $article->getId()->toString());
        $this->assertSame($record['title'], $article->getTitle());
        $this->assertSame($record['content'], $article->getContent());
    }
}
