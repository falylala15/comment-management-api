<?php

namespace Blog\Infrastructure\Symfony\Controller;

use Blog\Application\Query\ArticleQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
#[Route('/api/articles', name: 'blog_article_list', methods: ['GET'])]
class GetArticleListController
{
    public function __invoke(
        ArticleQuery $articleQuery,
        SerializerInterface   $serializer
    ): JsonResponse {
        return new JsonResponse(
            $serializer->serialize($articleQuery->fetchAll(), JsonEncoder::FORMAT),
            json: true
        );
    }
}
