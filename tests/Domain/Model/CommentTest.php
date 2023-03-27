<?php

namespace Domain\Model;

use Blog\Domain\Factory\ArticleFactory;
use Blog\Domain\Factory\CommentFactory;
use Blog\Domain\ValueObject\ArticleId;
use Blog\Domain\ValueObject\CommentId;
use Blog\Domain\ValueObject\Email;
use Tests\BaseTest;

class CommentTest extends BaseTest
{
    /**
     * @test
     */
    public function it_add_a_comment_for_article(): void
    {
        $articleId = ArticleId::generate();
        $article = ArticleFactory::create(id: $articleId, title: $this->faker->title(), content: $this->faker->text());

        for ($i = 1; $i <= 5; $i++) {
            $commentId = CommentId::generate();
            $content = $this->faker->text(50);
            $author = $this->faker->email();

            $comment = CommentFactory::create($commentId, $articleId, $content, Email::fromString($author));
            $article->addComment($comment);

            $this->assertSame($i, count($article->getComments()));
            $this->assertSame($articleId->toString(), $comment->getArticle()->toString());
            $this->assertSame($commentId, $comment->getId());
            $this->assertSame($content, $comment->getContent());
            $this->assertSame($author, $comment->getAuthor()->toString());
        }
    }

    /**
     * @test
     */
    public function it_create_an_article_from_database_record(): void
    {
        $record = [
            'id' => $this->faker->uuid(),
            'article_id' => $this->faker->uuid(),
            'content' => $this->faker->text(50),
            'author' => $this->faker->email(),
        ];

        $comment = CommentFactory::fromDatabaseRecord($record);

        $this->assertSame($record['id'], $comment->getId()->toString());
        $this->assertSame($record['article_id'], $comment->getArticle()->toString());
        $this->assertSame($record['content'], $comment->getContent());
        $this->assertSame($record['author'], $comment->getAuthor()->toString());
    }
}
