<?php

declare(strict_types=1);

namespace SebDru\Blog\Model;

// require_once("app/model/Manager.php");

class ArticleManager
{
    protected $table = 'article';

    /**
     * Return the list of articles.
     *
     * @return array
     */
    public function getArticles(?string $adminVisibility = null)
    {
        switch ($adminVisibility) {
            case null:
                $filter = "WHERE visibility ='published' ";
                break;
            case 'all':
                $filter = "WHERE 1 ";
                break;
        }


        $req = Manager::getInstance()->prepare('SELECT 
        article.id, 
        title,
        chapo,
        content, 
        DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr, 
        DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date_fr,
        visibility,
        name
        FROM article 
        INNER JOIN user ON article.author_id = user.id 
        ' . $filter . 'ORDER BY creation_date 
        DESC ');
        $req->execute();
        return $req->fetchAll();
    }

    /**
     * Return item of specific id from a specific table.
     *
     * @param integer $articleId
     *
     * @return mixed
     */
    public function getArticle(int $id): mixed
    {
        $req = Manager::getInstance()->prepare(
            'SELECT 
            article.id, 
            title, 
            chapo, 
            content, 
            DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr,
            DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date_fr,
            visibility,
            user.name 
            FROM article 
            INNER JOIN user ON article.author_id = user.id 
            WHERE article.id = ? 
            '
        );
        $req->execute([$id]);
        $item = $req->fetch();

        return $item;
    }

    public function registerArticle(Article $article): ?int
    {
        $id = $article->getArticleId();
        if (is_null($id)) {
            $req = Manager::getInstance()->prepare(
                'INSERT INTO article(
                title, 
                chapo, 
                content, 
                creation_date,
                modification_date,
                author_id,
                visibility
            ) VALUES( 
                :title, 
                :chapo, 
                :content, 
                :creationDate, 
                :modificationDate, 
                :authorId,
                :visibility)'
            );
            $req->bindParam(':title', $article->getTitle(), \PDO::PARAM_STR);
            $req->bindParam(':chapo', $article->getChapo(), \PDO::PARAM_STR);
            $req->bindParam(':content', $article->getContent(), \PDO::PARAM_STR);
            $req->bindParam(':creationDate', $article->getCreationDate(), \PDO::PARAM_STR);
            $req->bindParam(':modificationDate', $article->getModificationDate(), \PDO::PARAM_STR);
            $req->bindParam(':authorId', $article->getauthorId(), \PDO::PARAM_INT);
            $req->bindParam(':visibility', $article->getVisibility(), \PDO::PARAM_STR);
            $req->execute();
            $idArticleCreated = intval(Manager::getInstance()->lastInsertId());
            return $idArticleCreated;
        } elseif (is_int($id) && $id > 0) {

            $req = Manager::getInstance()->prepare(
                'UPDATE article
                SET
                title=:title,
                chapo=:chapo,
                content=:content,
                modification_date=:modificationDate,
                visibility=:visibility 
                WHERE id=:id'
            );
            $req->bindParam(':title', $article->getTitle(), \PDO::PARAM_STR);
            $req->bindParam(':chapo', $article->getChapo(), \PDO::PARAM_STR);
            $req->bindParam(':content', $article->getContent(), \PDO::PARAM_STR);
            $req->bindParam(':modificationDate', $article->getModificationDate(), \PDO::PARAM_STR);
            $req->bindParam(':visibility', $article->getVisibility(), \PDO::PARAM_STR);
            $req->bindParam(':id', $article->getArticleId(), \PDO::PARAM_INT);
            $req->execute();

            return $id;
        } else {
            throw new \Exception("L'id de l'article n'est pas dans un format correct");
        }
    }

    public function updateVisibilityOfArticle(int $id, string $visibility): ?int
    {
        $arg = compact('id', 'visibility');
        $req = Manager::getInstance()->prepare(
            'UPDATE article
            SET visibility=:visibility
            WHERE id=:id
        '
        );
        $req->execute($arg);
        $affectedLines = intval(Manager::getInstance()->lastInsertId());

        return $affectedLines;
    }
}
