<?php

namespace SebDru\Blog\Model;

abstract class Manager
{
    protected $dbConnect;
    protected $table;
    protected $dotenv;

    private static $_instance;

    public static function getIntance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Manager();
        }
        return self::$_instance;
    }

    public function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(ROOT);
        $dotenv->load();
        try {
            $dsn = $_ENV['MYSQL_DSN'];
            $user = $_ENV['MYSQL_USER'];
            $password = $_ENV['MYSQL_PASSWORD'];

            $this->dbConnect = new \PDO($dsn, $user, $password);

            return $this->dbConnect;
        } catch (\Exception $e) {
            exit('Erreur de connexion : ' . $e->getMessage());
        }
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
