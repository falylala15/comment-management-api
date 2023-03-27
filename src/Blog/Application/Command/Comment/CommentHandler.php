<?php

namespace Blog\Application\Command\Comment;

use Blog\Domain\Contracts\ArticleRepositoryInterface;
use Blog\Domain\Contracts\CommentRepositoryInterface;
use Blog\Domain\Factory\CommentFactory;
use Blog\Domain\ValueObject\CommentId;
use Blog\Domain\ValueObject\Email;

final class CommentHandler
{
    public function __construct(
        private readonly CommentRepositoryInterface $commentRepository,
        private readonly ArticleRepositoryInterface $articleRepository,
    ) {
    }

    public function handle(CommentCommand $command): string
    {
        $article = $this->articleRepository->getById($command->getArticleId());

        $comment = CommentFactory::create(
            CommentId::generate(),
            $command->getArticleId(),
            $command->getContent(),
            Email::fromString('johndoe@yopmail.com'), // @todo change for user connected
        );

        $this->commentRepository->save($comment);

        return $comment->getId()->toString();
    }
}
