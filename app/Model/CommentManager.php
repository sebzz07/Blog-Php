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

    public function getComments(?string $adminVisibility = null)
    {
        switch ($adminVisibility) {
            case null:
                $filter = "WHERE comment.visibility ='published' ";
                break;
            case 'all':
                $filter = "WHERE 1 ";
                break;
            case 'waitingForValidation':
                $filter = "WHERE comment.visibility ='waitingForValidation' ";
                break;
        }
        $req = Manager::getInstance()->prepare('SELECT 
        comment.id, 
        comment.content, 
        DATE_FORMAT(comment.creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr, 
        DATE_FORMAT(comment.modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date_fr,
        comment.article_id,
        comment.author_id,
        comment.visibility,
        user.name,
        article.title
        FROM comment 
        INNER JOIN user ON comment.author_id = user.id
        INNER JOIN article ON comment.article_id = article.id
        ' . $filter . 'ORDER BY comment.creation_date 
        DESC ');
        $req->execute();
        return $req->fetchAll();
    }
}
