<?php

declare(strict_types=1);

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;
use SebDru\Blog\Controller\Articles;
use SebDru\Blog\Controller\Controller;

class Comments extends Controller
{
    public function addComment(int $articleId, array $post, array $session)
    {
        if (!$session['userInformation'] || $session['userInformation']['status'] == 'banned') {
            throw new \Exception('Utilisateur non connecté ou/et banni');
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
        isset($articlesController) ? null : $articlesController = new Articles();
        $articlesController->article($articleId, $_SESSION, ['postCommentSuccess' => true]);
    }

    public function updateComment(int $commentId, array $post, array $session)
    {
        if (!$session['userInformation'] || $session['userInformation']['status'] == 'banned') {
            throw new \Exception('Utilisateur non connecté ou/et banni');
        }
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

    public function publishComment(int $idComment): void
    {
        $commentManager = new Model\CommentManager();
        $commentManager->updateVisibilityOfComment($idComment, "published");

        header('Location: index.php?action=PendingComments');
    }

    public function unpublishComment(int $idComment): void
    {
        $commentManager = new Model\CommentManager();
        $commentManager->updateVisibilityOfComment($idComment, "unpublished");

        header('Location: index.php?action=PendingComments');
    }
}
