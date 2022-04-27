<?php

namespace SebDru\Blog\Model;

require_once("model/Manager.php");

//use SebDru\Blog\Model\Manager;

class ArticleManager extends Manager
{
    public function getArticles()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT article.id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr, DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%imin%ss\') AS modification_date_fr, pseudo, image_link FROM article INNER JOIN user ON article.author_id = user.id ORDER BY creation_date DESC LIMIT 0, 5');

        return $req;
    }

    public function getArticle($articleId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM article WHERE id = ?');
        $req->execute(array($articleId));
        $article = $req->fetch();

        return $article;
    }
}
