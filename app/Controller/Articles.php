<?php

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;

class Articles extends Controller
{
    public function listArticles()
    {
        $articleManager = new Model\ArticleManager();
        $articles = $articleManager->getArticles();


        $this->twig->display('frontOffice/listArticles.html.twig', compact('articles'));
    }

    public function article(int $id)
    {
        $articleManager = new Model\ArticleManager();
        $commentManager = new Model\CommentManager();

        $article = $articleManager->getItem($id);
        $comments = $commentManager->getCommentsOfArticle($id);

        $this->twig->display('frontOffice/article.html.twig', compact('article', 'comments'));
    }

    public function createArticle(array $session)
    {

        $this->twig->display('backOffice/adminArticle.html.twig', ['session' => $session]);
    }

    public function editListArticles(array $session)
    {
        $this->twig->display('backOffice/adminArticles.html.twig', ['session' => $session]);
    }

    public function registerArticle(array $session, array $article)
    {
    }
}
