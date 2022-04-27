<?php
function getArticles()
{
    $db = dbConnect();
    $req = $db->query('SELECT article.id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr, DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin%ss\') AS modification_date_fr, pseudo, image_link FROM article INNER JOIN user ON article.author_id = user.id ORDER BY creation_date DESC LIMIT 0, 5');

    return $req;
}

function getArticle($articleId)
{
    $db = dbConnect();
    $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM article WHERE id = ?');
    $req->execute(array($articleId));
    $article = $req->fetch();

    return $article;
}

function getComments($articleId)
{
    $db = dbConnect();
    $comments = $db->prepare('SELECT id, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM comment WHERE article_id = ? ORDER BY creation_date DESC');
    $comments->execute(array($articleId));

    return $comments;
}

function dbConnect()
{
    try {
        $dsn = 'mysql:dbname=Blog-Php-BDD;host=0.0.0.0';
        $user = 'user';
        $password = 'password';

        $db = new PDO($dsn, $user, $password);
        return $db;
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
