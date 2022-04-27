<?php

require('model/ArticleManager.php');
require('model/CommentManager.php');


function listArticles()
{
    $ArticleManager = new \SebDru\Blog\Model\ArticleManager();
    $articles = $ArticleManager->getArticles();

    require('view/frontend/listArticlesView.php');
}

function article()
{
    $articleManager = new \SebDru\Blog\Model\ArticleManager();
    $commentManager = new \SebDru\Blog\Model\CommentManager();

    $article = $articleManager->getArticle($_GET['id']);
    $comments = $commentManager->getComments($_GET['id']);

    require('view/frontend/articleView.php');
}

function addComment($articleId, $userId, $content)
{
    $commentManager = new \SebDru\Blog\Model\CommentManager();
    $affectedLines = $commentManager->postComment($articleId, $userId, $content);

    if ($affectedLines === false) {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    } else {
        header('Location: index.php?action=post&id=' . $articleId);
    }
}

function about()
{

    require('view/frontend/about.php');
}

function contact()
{
    require('view/frontend/contact.php');
}
