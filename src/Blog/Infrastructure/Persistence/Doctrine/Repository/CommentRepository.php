<?php

namespace Blog\Infrastructure\Persistence\Doctrine\Repository;

use Blog\Domain\Contracts\CommentRepositoryInterface;
use Blog\Domain\Factory\CommentFactory;
use Blog\Domain\Model\Comment;
use Blog\Domain\ValueObject\ArticleId;
use Doctrine\DBAL\Connection;

final class CommentRepository implements CommentRepositoryInterface
{
    public function __construct(private readonly Connection $connection)
    {
    }

    public function save(Comment $comment): void
    {
        $this->connection->insert(
            'comment',
            [
                'id' => $comment->getId()->toString(),
                'article_id' => $comment->getArticle()->toString(),
                'content' => $comment->getContent(),
                'author' => $comment->getAuthor()->toString(),
                'createdat' => $comment->getCreatedAt()->format('Y-m-d H:i:s')
            ]
        );
    }

    /**
     * @return array<Comment>
     */
    public function getAll(?ArticleId $id = null): array
    {
        $qb = $this->connection
            ->createQueryBuilder()
            ->select('*');
        if ($id) {
            $qb
                ->where('article_id = :identifier')
                ->setParameter('identifier', $id->toString());
        }

        $records = $qb->from('comment')
            ->fetchAllAssociative();

        return \array_map([CommentFactory::class, 'fromDatabaseRecord'], $records);
    }
}
