<?php

namespace Blog\Domain\Model;

use Blog\Domain\ValueObject\ArticleId;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

final class Article
{
    private Collection $comments;

    public function __construct(
        private ArticleId $id,
        private string $title,
        private string $content,
    ) {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ArticleId
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setArticle($this->id);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id->toString();
    }

    /**
     * @return array<string>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
