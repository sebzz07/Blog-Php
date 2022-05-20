<?php

define('ROOT', __DIR__);

// require_once('app/autoload.php');
require_once 'vendor/autoload.php';

use SebDru\Blog\Controller\Articles;
use SebDru\Blog\Controller\Comments;
use SebDru\Blog\Controller\Pages;
use SebDru\Blog\Controller\Users;

//  Routing
try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'about':
                $pagesController ? null : $pagesController = new Pages();
                $pagesController->about();
                break;

            case 'contact':
                $pagesController ? null : $pagesController = new Pages();
                $pagesController->contact();
                break;

            case 'registerUser':
                $pagesController ? null : $pagesController = new Pages();
                $pagesController->registerUser();
                break;

            case 'addComment':
                $id = htmlspecialchars($_GET['id']);
                $comment = htmlspecialchars($_POST['comment']);
                if (isset($id) && $id > 0) {
                    if (!empty($comment)) {
                        $commentsController ? null : $commentsController = new Comments();
                        $commentsController->addComment($id, $comment);
                    } else {
                        throw new Exception('Tous les champs ne sont pas remplis');
                    }
                } else {
                    throw new Exception('Aucun identifiant d\'article envoyé');
                }
                break;

            case 'login':
                if (!isset($_SESSION['name'])) {
                    $pagesController ? null : $pagesController = new Pages();
                    $pagesController->login();
                }
                break;

            case 'addUser':
                $usersController ? null : $usersController = new Users();
                $arg = $usersController->filterInput($_POST);
                $usersController->addUser($_POST);
                break;

            case 'connect':
                isset($usersController) ? null : $usersController = new Users();
                $arg = $usersController->filterInput($_POST);

                if (isset($arg)) {
                    $usersController->connect($arg['name'], $arg['password']);
                } else {
                    throw new Exception('Aucun identifiant envoyé');
                }
                break;

            case 'disconnect':
                $usersController ? null : $usersController = new Users();
                $usersController->disconnect();
                break;

            case 'listArticles':
                $articlesController ? null : $articlesController = new Articles();
                $articlesController->listArticles();
                break;

            case 'article':
                $articlesController ? null : $articlesController = new Articles();
                $arg = $articlesController->filterInput($_GET);

                if (isset($arg['id']) && $arg['id'] > 0) {
                    $articlesController->article($arg['id']);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;
        }
    } else {
        $pagesController ? null : $pagesController = new Pages();
        $pagesController->landing();
    }
} catch (Exception $e) {
    echo 'Erreur : '.$e->getMessage();
}
