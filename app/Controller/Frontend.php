<?php

namespace SebDru\Blog\Controller;

//require_once('vendor/autoload.php');
//require_once('app/controller/Controller.php');
//require('app/model/ArticleManager.php');
//require('app/model/CommentManager.php');

use SebDru\Blog\Model;

class Frontend extends Controller
{
    

    public function listArticles()
    {
        $articleManager = new Model\ArticleManager();
        $articles = $articleManager->getArticles();

        $this->twig->display('frontend/listArticlesView.html.twig', compact('articles'));
    }

    public function article()
    {
        $articleManager = new Model\ArticleManager();
        $commentManager = new Model\CommentManager();

        $article = $articleManager->getItem($_GET['id']);
        $comments = $commentManager->getCommentsOfArticle($_GET['id']);

        $this->twig->display('frontend/articleView.html.twig', compact('article','comments'));
    }

    public function addComment($articleId, $userId, $content)
    {
        $commentManager = new Model\CommentManager();
        $affectedLines = $commentManager->postComment($articleId, $userId, $content);

        if ($affectedLines === false) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=post&id=' . $articleId);
        }
    }

    public function about()
    {
        $this->twig->display('frontend/about.html.twig');
    }

    public function contact()
    {
        $this->twig->display('frontend/contact.html.twig');
    }
    public function registerUser()
    {
        //$articleManager = new Model\ArticleManager();
        //$articles = $articleManager->getArticles();

        $this->twig->display('frontend/register.html.twig');
    }
}
