<?php

namespace SebDru\Blog\Model;

// require_once("app/model/Manager.php");

class CommentManager
{
    public function getCommentsOfArticle($articleId)
    {
        $req = Manager::getInstance()->prepare('SELECT comment.id, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr, name FROM comment INNER JOIN user ON comment.author_id = user.id WHERE article_id = ? ORDER BY creation_date DESC');
        $req->execute([$articleId]);

        return $req;
    }

    public function postComment($articleId, $content)
    {
        $req = Manager::getInstance()->prepare('INSERT INTO comment(article_id, author_id, content) VALUES(?, ?, ?)');
        $affectedLines = $req->execute([$articleId, 13, $content]);

        return $affectedLines;
    }
}
