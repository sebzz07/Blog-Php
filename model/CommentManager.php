<?php

namespace SebDru\Blog\Model;

require_once("model/Manager.php");

class CommentManager extends Manager
{
    public function getComments($articleId)
    {
        $db = new $this->dbConnect();
        $comments = $db->prepare('SELECT id, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM comment WHERE article_id = ? ORDER BY creation_date DESC');
        $comments->execute(array($articleId));

        return $comments;
    }

    public function postComment($articleId, $userId, $content)
    {
        $db = $this->dbConnect();
        $comments = $db->prepare('INSERT INTO comment(article_id, author_id, content, comment_date) VALUES(?, ?, ?, NOW())');
        $affectedLines = $comments->execute(array($articleId, $userId, $content));

        return $affectedLines;
    }
}
