<?php

define('ROOT', __DIR__);

// require_once('app/autoload.php');
require_once 'vendor/autoload.php';

use SebDru\Blog\Controller\Pages;
use SebDru\Blog\Controller\Users;
use SebDru\Blog\Controller\Contact;
use SebDru\Blog\Controller\Articles;
use SebDru\Blog\Controller\Comments;

session_start();
//  Routing
try {
    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'about':
                isset($pagesController) ? null : $pagesController = new Pages();
                $pagesController->about();
                break;

            case 'contact':
                isset($pagesController) ? null : $pagesController = new Pages();
                $pagesController->contact();
                break;

            case 'registerUser':
                isset($pagesController) ? null : $pagesController = new Pages();
                $pagesController->registerUser();
                break;

            case 'addComment':
                $id = htmlspecialchars($_GET['id']);
                $comment = htmlentities($_POST['comment']);
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
                    isset($pagesController) ? null : $pagesController = new Pages();
                    $pagesController->login();
                }
                break;

            case 'addUser':
                isset($pagesController) ? null : $usersController = new Users();
                $arg = $usersController->filterInput($_POST);
                $usersController->addUser($_POST);
                break;

            case 'connect':

                isset($usersController) ? null : $usersController = new Users();
                $arg = $usersController->filterInput($_POST);

                if (isset($arg['name']) && isset($arg['password'])) {
                    $usersController->connect($arg['name'], $arg['password']);
                } else {
                    throw new Exception('Les identifiants ne sont pas définis ou envoyés correctement');
                }
                break;

            case 'disconnect':
                isset($usersController) ? null : $usersController = new Users();
                $usersController->disconnect();
                break;

            case 'listArticles':
                isset($articleController) ? null : $articlesController = new Articles();
                $articlesController->listArticles();
                break;

            case 'article':
                isset($articleController) ? null : $articlesController = new Articles();
                $arg = $articlesController->filterInput($_GET);

                if (isset($arg['id']) && $arg['id'] > 0) {
                    $articlesController->article($arg['id']);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'send':
                isset($contactController) ? null : $contactController = new Contact();
                $contactController->send();
                break;

            case 'createArticle':
                if (isset($_SESSION) && $_SESSION['userInformation']['admin'] === 1) {
                    isset($articleController) ? null : $articlesController = new Articles();
                    $articlesController->createArticle($_SESSION);
                } else {
                    throw new Exception("Vous n'avez pas les droits");
                }

            case 'registerArtcile':
                isset($articleController) ? null : $articlesController = new Articles();
                $arg = $articlesController->filterInput($_Post);
                $articlesController->registerArticle($_SESSION, $arg);
        }
    } else {
        isset($pagesController) ? null : $pagesController = new Pages();
        $pagesController->index();
    }
} catch (Exception $e) {
    isset($pagesController) ? null : $pagesController = new Pages();
    $pagesController->error($e->getMessage() ? $e->getMessage() : null);
}
