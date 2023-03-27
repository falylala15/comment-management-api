<?php

namespace Blog\Infrastructure\Symfony\Controller;

use Blog\Application\Query\ArticleQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[Route('/api/articles/{articleId}', name: 'blog_article_detail', methods: ['GET'])]
class GetArticleController
{
    public function __invoke(
        string $articleId,
        ArticleQuery $articleQuery,
        SerializerInterface $serializer
    ): JsonResponse {
        return new JsonResponse(
            $serializer->serialize(
                $articleQuery->getOne($articleId),
                JsonEncoder::FORMAT
            ),
            json: true
        );
    }
}
