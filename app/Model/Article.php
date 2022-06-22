<?php

declare(strict_types=1);

namespace SebDru\Blog\Model;

class Article
{
    private ?int $articleId = null;
    private string $title = "";
    private string $chapo = "";
    private string $content = "";
    private string $creationDate = "";
    private string $modificationDate = "";
    private int $authorId = 0;
    private string $visibility = "unpublished";

    public function setArticleId(int $articleId): self
    {
        $this->articleId = $articleId;
        return $this;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function setChapo(string $chapo): self
    {
        $this->chapo = $chapo;
        return $this;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
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

    public function setAuthorId(int $authorId): self
    {
        $this->authorId = $authorId;
        return $this;
    }

    public function setVisibility(string $visibility): self
    {
        $this->visibility = $visibility;
        return $this;
    }

    public function getArticleId(): ?int
    {
        return $this->articleId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getChapo(): string
    {
        return $this->chapo;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    public function getModificationDate(): string
    {
        return $this->modificationDate;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getVisibility(): string
    {
        return $this->visibility;
    }
}
