<?php

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;

class Articles extends Controller
{
    public function listArticles(?string $adminVisibility = null): void
    {
        $articleManager = new Model\ArticleManager();
        $articles = $articleManager->getArticles($adminVisibility);


        $this->twig->display('frontOffice/listArticles.html.twig', compact('articles'));
    }

    public function article(int $idArticle, array $postCommentSuccess = ['postCommentSuccess' => false])
    {
        $articleManager = new Model\ArticleManager();
        $commentManager = new Model\CommentManager();

        $article = $articleManager->getArticle($idArticle);
        $comments = $commentManager->getCommentsOfArticle($idArticle);
        $this->twig->display('frontOffice/article.html.twig', compact('article', 'comments', 'postCommentSuccess'));
    }

    public function createArticle(array $session)
    {

        $this->twig->display('backOffice/adminArticle.html.twig', ['session' => $session]);
    }

    public function editListArticles(array $session)
    {
        $adminVisility = "all";
        $articleManager = new Model\ArticleManager();
        $articles = $articleManager->getArticles($adminVisility);

        $this->twig->display('backOffice/adminArticles.html.twig', compact('articles', 'session'));
    }

    public function registerArticle(array $session, array $post)
    {
        date_default_timezone_set('Europe/Paris');

        $article = new Model\Article();
        $article
            ->setTitle($post['title'])
            ->setChapo($post['chapo'])
            ->setContent($post['content'])
            ->setCreationDate(date("Y-m-d H:i:s"))
            ->setModificationDate(date("Y-m-d H:i:s"))
            ->setAuthorId($session['userInformation']['id'])
            ->setVisibility("waitingForValidation");

        $articleManager = new Model\ArticleManager();
        $articleId = $articleManager->registerArticle($article);

        header('Location: index.php?action=article&id=' . $articleId);
    }

    public function publishArticle(int $idArticle)
    {
        $articleManager = new Model\ArticleManager();
        $articleManager->updateVisibilityOfArticle($idArticle, "published");

        header('Location: index.php?action=listArticles');
    }

    public function unpublishArticle(int $idArticle): void
    {
        $articleManager = new Model\ArticleManager();
        $articleManager->updateVisibilityOfArticle($idArticle, "unpublished");

        header('Location: index.php?action=listArticles');
    }

    public function EditArticle(array $session, int $idArticle): void
    {
        $articleManager = new Model\ArticleManager();
        $commentManager = new Model\CommentManager();

        $comments = $commentManager->getCommentsOfArticle($idArticle, 'all');
        $article = $articleManager->getArticle($idArticle);

        $this->twig->display('backOffice/adminArticle.html.twig', compact('session', 'article', 'comments'));
    }

    public function updateArticle(int $idArticle, array $post)
    {
        date_default_timezone_set('Europe/Paris');

        $article = new Model\Article();
        $article
            ->setArticleId($idArticle)
            ->setTitle($post['title'])
            ->setChapo($post['chapo'])
            ->setContent($post['content'])
            ->setModificationDate(date("Y-m-d H:i:s"))
            ->setVisibility("waitingForValidation");

        $articleManager = new Model\ArticleManager();
        $articleId = $articleManager->registerArticle($article);

        header('Location: index.php?action=article&id=' . $articleId);
    }
}
