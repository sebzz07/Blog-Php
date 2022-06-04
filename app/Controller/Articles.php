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

    public function article(int $id)
    {
        $articleManager = new Model\ArticleManager();
        $commentManager = new Model\CommentManager();

        $article = $articleManager->getItem($id);
        $comments = $commentManager->getCommentsOfArticle($id);

        $this->twig->display('frontend/article.html.twig', compact('article', 'comments'));
    }
}
