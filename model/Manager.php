<?php

namespace SebDru\Blog\Model;

abstract class Manager
{
    protected $dbConnect;
    protected $table;

    public function __construct()
    {
        try {
            $dsn = 'mysql:dbname=Blog-Php-BDD;host=0.0.0.0';
            $user = '';
            $password = '';

            $this->dbConnect = new \PDO($dsn, $user, $password);
            return $this->dbConnect;
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }


    /**
     * Return item of specific id from a specific table
     *
     * @param [integer] $articleId
     * @return void
     */
    public function getItem(int $id)
    {
        $req = $this->dbConnect->prepare("SELECT {$this->table}.id, title, content, DATE_FORMAT(creation_date, '%d/%m/%Y à %Hh%imin%ss') AS creation_date_fr, user.pseudo FROM {$this->table} INNER JOIN user ON {$this->table}.author_id = user.id WHERE {$this->table}.id = {$id} ");
        $req->execute();
        $item = $req->fetch();
        return $item;
    }


}
