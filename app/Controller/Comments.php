<?php

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;

class Comments extends Controller
{
    public function addComment(string $articleId, array $post, array $session)
    {
        if (!$session['userInformation']) {
            throw new \Exception('Utilisateur non connecté');
        }
        date_default_timezone_set('Europe/Paris');
        $comment = new Model\Comment();
        $comment
            ->setContent($post['comment'])
            ->setCreationDate(date("Y-m-d H:i:s"))
            ->setModificationDate(date("Y-m-d H:i:s"))
            ->setArticleId($articleId)
            ->setAuthorId($session['userInformation']['id'])
            ->setVisibility("waitingForValidation");

        $commentManager = new Model\CommentManager();
        $commentadded = $commentManager->registerComment($comment);

        if (false === $commentadded) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        }
        header('Location: index.php?action=article&id=' . $articleId);
    }

    public function updateComment(int $commentId, array $post, array $session)
    {
        date_default_timezone_set('Europe/Paris');

        $comment = new Model\Comment();
        $comment
            ->setCommentId($commentId)
            ->setContent($post['content'])
            ->setModificationDate(date("Y-m-d H:i:s"))
            ->setVisibility("waitingForValidation");

        $commentManager = new Model\CommentManager();
        $commentId = $commentManager->registerComment($comment);
        $articleIdOfComment = $commentManager->getComment($commentId);

        header('Location: index.php?action=editArticle&id=' . $articleIdOfComment['article_id']);
    }

    public function listPendingComments(?string $adminVisibility = null): void
    {
        $adminVisibility = "waitingForValidation";
        $commentManager = new Model\CommentManager();
        $comments = $commentManager->getComments($adminVisibility);


        $this->twig->display('backOffice/adminPendingComments.html.twig', compact('comments'));
    }

    public function publishComment(int $id): void
    {
        $commentManager = new Model\CommentManager();
        $commentManager->updateVisibilityOfComment($id, "published");

        header('Location: index.php?action=PendingComments');
    }

    public function unpublishComment(int $id): void
    {
        $commentManager = new Model\CommentManager();
        $commentManager->updateVisibilityOfComment($id, "unpublished");

        header('Location: index.php?action=PendingComments');
    }
}
