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

    public function article(int $id)
    {
        $articleManager = new Model\ArticleManager();
        $commentManager = new Model\CommentManager();

        $article = $articleManager->getArticle($id);
        $comments = $commentManager->getCommentsOfArticle($id);

        $this->twig->display('frontOffice/article.html.twig', compact('article', 'comments'));
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

    public function publishArticle(int $id)
    {
        $articleManager = new Model\ArticleManager();
        $articleManager->updateVisibilityOfArticle($id, "published");

        header('Location: index.php?action=listArticles');
    }

    public function unpublishArticle(int $id): void
    {
        $articleManager = new Model\ArticleManager();
        $articleManager->updateVisibilityOfArticle($id, "unpublished");

        header('Location: index.php?action=listArticles');
    }

    public function EditArticle(array $session, int $id): void
    {
        $articleManager = new Model\ArticleManager();
        $commentManager = new Model\CommentManager();

        $comments = $commentManager->getCommentsOfArticle($id, 'all');
        $article = $articleManager->getArticle($id);

        $this->twig->display('backOffice/adminArticle.html.twig', compact('session', 'article', 'comments'));
    }

    public function updateArticle(int $id, array $post)
    {
        date_default_timezone_set('Europe/Paris');

        $article = new Model\Article();
        $article
            ->setArticleId($id)
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
