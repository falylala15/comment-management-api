<?php

namespace Tests\Application\Command;

use Blog\Application\Command\Comment\CommentCommand;
use Blog\Application\Command\Comment\CommentHandler;
use Blog\Domain\Factory\ArticleFactory;
use Blog\Domain\ValueObject\ArticleId;
use Blog\Domain\ValueObject\CommentId;
use Tests\BaseTest;
use Tests\Infrastructure\Doctrine\Persistence\Doubles\InMemoryArticleRepository;
use Tests\Infrastructure\Doctrine\Persistence\Doubles\InMemoryCommentRepository;

class CommentHandlerTest extends BaseTest
{
    /**
     * @test
     */
    public function it_an_comment_can_be_created(): void
    {
        $articleId = $this->faker->uuid();
        $content = $this->faker->text();
        $command = new CommentCommand($articleId, $content);
        $commentRepository = new InMemoryCommentRepository();
        $articleRepository = new InMemoryArticleRepository();
        $articleRepository->save(ArticleFactory::create(ArticleId::fromString($articleId), $this->faker->text(), $this->faker->text()));

        $commentHandler = new CommentHandler($commentRepository, $articleRepository);
        $commentId = $commentHandler->handle($command);

        $articleHasBeenCreated = $commentRepository->getById(CommentId::fromString($commentId));

        $this->assertSame($articleId, $articleHasBeenCreated->getArticle()->toString());
        $this->assertSame($content, $articleHasBeenCreated->getContent());
    }
}
