<?php

namespace SebDru\Blog\Model;

use Exception;

class Comment
{
    private int $articleId = 0;
    private int $authorId = 0;
    private string $content = "";

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

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
