<?php

namespace SebDru\Blog\Model;

use Exception;

class Comment
{
    private ?int $commentId = null;
    private ?string $content = null;
    private ?string $creationDate = null;
    private ?string $modificationDate = null;
    private ?int $articleId = null;
    private ?int $authorId = null;
    private ?string $visibility = null;

    public function setCommentId(int $commentId): self
    {
        $this->commentId = $commentId;
        return $this;
    }

    public function setArticleId(int $articleId): self
    {
        $this->articleId = $articleId;
        return $this;
    }

    public function setAuthorId(int $authorId): self
    {
        $this->authorId = $authorId;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function setVisibility(string $visibility): self
    {
        $this->visibility = $visibility;
        return $this;
    }

    public function setCreationDate(string $creationDate): self
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function setModificationDate(?string $modificationDate): self
    {
        $this->modificationDate = $modificationDate;
        return $this;
    }

    public function getCommentId(): ?int
    {
        return $this->commentId;
    }

    public function getArticleId(): ?int
    {
        return $this->articleId;
    }

    public function getAuthorId(): ?int
    {
        return $this->authorId;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    public function getCreationDate(): ?string
    {
        return $this->creationDate;
    }

    public function getModificationDate(): ?string
    {
        return $this->modificationDate;
    }
}
