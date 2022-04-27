<?php

namespace SebDru\Blog\Model;

class Manager
{
    protected function dbConnect()
    {
        try {
            $dsn = 'mysql:dbname=Blog-Php-BDD;host=0.0.0.0';
            $user = '';
            $password = '';

            $db = new \PDO($dsn, $user, $password);
            return $db;
        } catch (\Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
