<?php

namespace SebDru\Blog\Model;

// require_once("app/model/Manager.php");

class CommentManager
{
    public function getComment($commentId)
    {
        $req = Manager::getInstance()->prepare('SELECT 
            comment.id, 
            content, 
            DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr,
            DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date_fr,
            comment.content, 
            comment.creation_date,
            comment.modification_date,
            comment.article_id,
            comment.author_id,
            comment.visibility 
            name 
            FROM comment INNER JOIN user ON comment.author_id = user.id 
            WHERE comment.id = ? 
            ');
        $req->execute([$commentId]);

        return $req->fetch();
    }

    public function getCommentsOfArticle($articleId, ?string $adminVisibility = null)
    {
        switch ($adminVisibility) {
            case null:
                $filter = "AND visibility ='published' ";
                break;
            case 'all':
                $filter = "";
        }
        $req = Manager::getInstance()->prepare("SELECT 
            comment.id, 
            content, 
            DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS creation_date_fr,
            DATE_FORMAT(modification_date, '%d/%m/%Y à %Hh%i') AS modification_date_fr,
            comment.visibility, 
            name 
            FROM comment INNER JOIN user ON comment.author_id = user.id 
            WHERE article_id = ? " . $filter . "
            AND (user.status = 'user'
            OR user.status = 'admin')
            ORDER BY creation_date DESC");
        $req->execute([$articleId]);

        return $req->fetchAll();;
    }

    public function registerComment(Comment $comment): ?int
    {
        $id = $comment->getCommentId();
        $content = $comment->getContent();
        $creationDate = $comment->getCreationDate();
        $modificationDate = $comment->getModificationDate();
        $articleId = $comment->getArticleId();
        $authorId = $comment->getAuthorId();
        $visibility = $comment->getVisibility();

        if ($id === null) {

            $req = Manager::getInstance()->prepare(
                'INSERT INTO comment( 
                content, 
                creation_date,
                modification_date,
                article_id,
                author_id,
                visibility
            ) VALUES( 
                :content, 
                :creationDate, 
                :modificationDate,
                :articleId, 
                :authorId,
                :visibility)'
            );
            $req->bindParam(':content', $content, \PDO::PARAM_STR);
            $req->bindParam(':creationDate', $creationDate, \PDO::PARAM_STR);
            $req->bindParam(':modificationDate', $modificationDate, \PDO::PARAM_STR);
            $req->bindParam(':articleId', $articleId, \PDO::PARAM_INT);
            $req->bindParam(':authorId', $authorId, \PDO::PARAM_INT);
            $req->bindParam(':visibility', $visibility, \PDO::PARAM_STR);
            $req->execute();
            $idCommentCreated = Manager::getInstance()->lastInsertId();
            return $idCommentCreated;
        } elseif (is_int($id) && $id > 0) {

            $req = Manager::getInstance()->prepare(
                'UPDATE comment
                SET
                content=:content,
                modification_date=:modificationDate,
                visibility=:visibility 
                WHERE id=:id'
            );
            $req->bindParam(':content', $content, \PDO::PARAM_STR);
            $req->bindParam(':modificationDate', $comment->getModificationDate(), \PDO::PARAM_STR);
            $req->bindParam(':visibility', $comment->getVisibility(), \PDO::PARAM_STR);
            $req->bindParam(':id', $id, \PDO::PARAM_INT);
            $req->execute();
            return $id;
        } else {
            throw new \Exception("L'id de l'aticle n'est pas dans un format correct");
        }
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
        $req = Manager::getInstance()->prepare("SELECT 
        comment.id, 
        comment.content, 
        DATE_FORMAT(comment.creation_date, '%d/%m/%Y à %Hh%i') AS creation_date_fr, 
        DATE_FORMAT(comment.modification_date, '%d/%m/%Y à %Hh%i') AS modification_date_fr,
        comment.article_id,
        comment.author_id,
        comment.visibility,
        user.name,
        article.title
        FROM comment 
        INNER JOIN user ON comment.author_id = user.id
        INNER JOIN article ON comment.article_id = article.id
        " . $filter . "
        AND (user.status = 'user'
        OR user.status = 'admin')
        ORDER BY comment.creation_date 
        DESC ");
        $req->execute();
        return $req->fetchAll();
    }

    public function updateVisibilityOfComment(int $id, string $visibility): ?int
    {
        $arg = compact('id', 'visibility');
        $req = Manager::getInstance()->prepare(
            'UPDATE comment
            SET visibility=:visibility
            WHERE id=:id
        '
        );
        $req->execute($arg);
        $affectedLines = Manager::getInstance()->lastInsertId();

        return $affectedLines;
    }
}
