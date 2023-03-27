<?php

namespace Blog\Application\Command\Comment\Validator;

use Blog\Application\Command\Comment\CommentCommand;
use Doctrine\Instantiator\Exception\InvalidArgumentException;

final class CommentValidator
{
    /**
     * @return array<string, array<int, string>>
     */
    public function validate(CommentCommand $comment): array
    {
        $errors = [];

        if (empty($comment->getContent())) {
            $errors['content'][] = 'Provide an message content.';
        }

        try {
            $comment->getArticleId();
        } catch (InvalidArgumentException) {
            $errors['article'][] = 'Provide an article identifier.';
        }

        return $errors;
    }
}
