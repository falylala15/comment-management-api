<?php

namespace Blog\Infrastructure\Symfony\Controller;

use Blog\Application\Query\CommentQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[Route('/api/articles/{articleId}/comments', name: 'blog_article_comments_list', methods: 'GET')]
class GetArticleCommentsController
{
    public function __invoke(
        Request $request,
        CommentQuery $commentQuery,
        SerializerInterface   $serializer
    ): JsonResponse {
        return new JsonResponse(
            $serializer->serialize($commentQuery->fetchAll($request->attributes->get('articleId')), JsonEncoder::FORMAT),
            json: true
        );
    }
}
