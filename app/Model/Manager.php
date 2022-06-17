<?php

namespace SebDru\Blog\Model;

use PDO;

class Manager
{
    private static $dbConnect;
    protected $table;
    protected $dotenv;

    private static $_instance;

    private function __construct()
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(ROOT);
        $dotenv->load();
        try {
            $dsn = $_ENV['MYSQL_DSN'];
            $user = $_ENV['MYSQL_USER'];
            $password = $_ENV['MYSQL_PASSWORD'];

            self::$_instance = new PDO($dsn, $user, $password);
        } catch (\Exception $e) {
            exit('Erreur de connexion : ' . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            new Manager();
        }
        return self::$_instance;
    }
}
