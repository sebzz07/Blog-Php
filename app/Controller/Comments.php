<?php

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;

class Comments extends Controller
{
    public function addComment(string $articleId, string $content)
    {
        $commentManager = new Model\CommentManager();
        $affectedLines = $commentManager->postComment($articleId, $content);

        if (false === $affectedLines) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        }
        header('Location: index.php?action=article&id=' . $articleId);
    }
}