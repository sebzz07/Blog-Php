<?php

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;

class Articles extends Controller
{
    public function listArticles()
        {
            $articleManager = new Model\ArticleManager();
            $articles = $articleManager->getArticles();

            $this->twig->display('frontend/listArticles.html.twig', compact('articles'));
        }

    public function article()
    {
        $articleManager = new Model\ArticleManager();
        $commentManager = new Model\CommentManager();

        $article = $articleManager->getItem($_GET['id']);
        $comments = $commentManager->getCommentsOfArticle($_GET['id']);

        $this->twig->display('frontend/article.html.twig', compact('article', 'comments'));
    }

}