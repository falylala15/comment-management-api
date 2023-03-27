<?php

namespace Blog\Application\Query;

use Blog\Domain\Factory\ArticleFactory;
use Blog\Domain\Factory\CommentFactory;
use Blog\Domain\ValueObject\ArticleId;
use Blog\Domain\ValueObject\CommentId;
use Blog\Domain\ValueObject\Email;
use Tests\BaseTest;
use Tests\Infrastructure\Doctrine\Persistence\Doubles\InMemoryCommentRepository;

class CommentQueryTest extends BaseTest
{
    /**
     * @test
     */
    public function it_should_fetch_all_article(): void
    {
        $commentRepository = new InMemoryCommentRepository();
        $articleId = ArticleId::generate();
        $article = ArticleFactory::create(id: $articleId, title: $this->faker->title(), content: $this->faker->text());

        for ($i = 1; $i <= 5; $i++) {
            $commentId = CommentId::generate();
            $content = $this->faker->text(50);
            $author = $this->faker->email();

            $comment = CommentFactory::create($commentId, $articleId, $content, Email::fromString($author));
            $article->addComment($comment);

            $commentRepository->save($comment);
        }

        $commentQuery = new CommentQuery($commentRepository);
        $comments = $commentQuery->fetchAll($articleId->toString());

        $this->assertCount(5, $comments);
    }
}
