<?php

namespace SebDru\Blog\Model;

require_once("model/Manager.php");

class CommentManager extends Manager
{
    public function getCommentsOfArticle($articleId)
    {
        $req = $this->dbConnect->prepare('SELECT comment.id, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr, pseudo FROM comment INNER JOIN user ON comment.author_id = user.id WHERE article_id = ? ORDER BY creation_date DESC');
        $req->execute(array($articleId));
        
        return $req;
    }

    public function postComment($articleId, $userId, $content)
    {
        $comments = $this->dbConnect->prepare('INSERT INTO comment(article_id, author_id, content, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($articleId, $userId, $content));

        return $affectedLines;
    }
}
