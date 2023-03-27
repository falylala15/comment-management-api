<?php

namespace Blog\Infrastructure\Symfony\Controller;

use Blog\Application\Command\Comment\CommentCommand;
use Blog\Application\Command\Comment\CommentHandler;
use Blog\Application\Command\Comment\Validator\CommentValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[Route('/api/articles/{articleId}/comments', name: 'blog_article_comment_create', methods: 'POST')]
class PostCommentController
{
    public function __invoke(
        Request             $request,
        CommentHandler      $commentHandler,
        SerializerInterface $serializer,
        CommentValidator    $validator
    ): JsonResponse {
        $command = new CommentCommand(
            (string) $request->attributes->get('articleId'),
            (string) $request->toArray()['content'],
        );

        $errors = $validator->validate($command);
        if (!empty($errors)) {
            return new JsonResponse($errors, JsonResponse::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($commentHandler->handle($command), JsonResponse::HTTP_CREATED);
    }
}
