<?php

namespace SebDru\Blog\Model;

// require_once("app/model/Manager.php");

class ArticleManager extends Manager
{
    protected $table = 'article';

    /**
     * Return the list of articles.
     *
     * @return array
     */
    public function getArticles()
    {
        $req = $this->dbConnect->query('SELECT 
        article.id, 
        title, content, 
        DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%i\') AS creation_date_fr, 
        DATE_FORMAT(modification_date, \'%d/%m/%Y à %Hh%i\') AS modification_date_fr,
        name
        FROM article 
        INNER JOIN user ON article.author_id = user.id 
        WHERE 1 ORDER BY creation_date 
        DESC LIMIT 0, 5');
        return $req;
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
        $req = $this->dbConnect->prepare("SELECT {$this->table}.id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS creation_date_fr, user.name FROM {$this->table} INNER JOIN user ON {$this->table}.author_id = user.id WHERE {$this->table}.id = {$id} ");
        $req->execute();
        $item = $req->fetch();

        return $item;
    }
}
