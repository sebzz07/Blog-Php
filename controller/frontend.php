<?php

require('model/frontend.php');

function listArticles()
{
    $articles = getArticles();

    require('view/frontend/listArticlesView.php');
}

function article()
{
    $article = getArticle($_GET['id']);
    $comments = getComments($_GET['id']);

    require('view/frontend/articleView.php');
}

function about()
{

    require('view/frontend/about.php');
}

function contact()
{
    require('view/frontend/contact.php');
}
