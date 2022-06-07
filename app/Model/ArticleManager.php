<?php

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
    public function getArticles()
    {
        $req = Manager::getInstance()->query('SELECT 
        article.id, 
        title,
        chapo,
        content, 
        DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr, 
        DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date_fr,
        name
        FROM article 
        INNER JOIN user ON article.author_id = user.id 
        WHERE 1 ORDER BY creation_date 
        DESC LIMIT 0, 5');
        return $req->fetchAll();
    }

    /**
     * Return item of specific id from a specific table.
     *
     * @param integer $articleId
     *
     * @return mixed
     */
    public function getItem(int $id): mixed
    {

        $req = Manager::getInstance()->prepare("SELECT {$this->table}.id, title, chapo, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS creation_date_fr, user.name FROM {$this->table} INNER JOIN user ON {$this->table}.author_id = user.id WHERE {$this->table}.id = {$id} ");
        $req->execute();
        $item = $req->fetch();

        return $item;
    }

    public function registerArticle()
    {
        $req = Manager::getInstance()->prepare('INSERT INTO article
        (article.id, 
        title, 
        chapo, 
        content, 
        creation_date,
        author_id) 
        VALUES(?, ?, ?, ?, ?, ?)');
        $affectedLines = $req->execute();

        return $affectedLines;
    }
}
