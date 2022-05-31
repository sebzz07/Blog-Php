<?php

namespace SebDru\Blog\Model;

use DateTime;
use Exception;

class Article
{
    private int $articleId = 0;
    private string $title = "";
    private string $content = "";
    private ?string $creationDate = null;
    private ?string $modificationDate = null;
    private int $authorId = 0;

    public function setArticleId(int $articleId): self
    {
        $this->articleId = $articleId;
        return $this;
    }

    public function setTitle(int $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function setCreationDate(int $creationDate): self
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    public function setModificationDate(int $modificationDate): self
    {
        $this->modificationDate = $modificationDate;
        return $this;
    }

    public function setAuthorId(int $authorId): self
    {
        $this->authorId = $authorId;
        return $this;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function getTitle(): int
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreationDate(): int
    {
        return $this->creationDate;
    }

    public function getModificationDate(): int
    {
        return $this->modificationDate;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }
}
