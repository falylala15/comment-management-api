<?php

namespace Tests\Domain\DTO;

use Blog\Domain\Factory\CommentFactory;
use Tests\BaseTest;

class CommentTest extends BaseTest
{
    /**
     * @test
     */
    public function it_can_be_create_an_comment_from_database_record(): void
    {
        $record = [
            'id' => $this->faker->uuid(),
            'content' => $this->faker->text(50),
            'article_id' => $this->faker->uuid(),
            'author' => $this->faker->email(),
        ];

        $comment = CommentFactory::fromDatabaseRecord($record);

        $this->assertSame($record['id'], $comment->getId()->toString());
        $this->assertSame($record['content'], $comment->getContent());
        $this->assertSame($record['article_id'], $comment->getArticle()->toString());
        $this->assertSame($record['author'], $comment->getAuthor()->toString());
    }
}
