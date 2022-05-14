<?php
define('ROOT',__DIR__);

//require_once('app/autoload.php');
require_once('vendor/autoload.php');

use SebDru\Blog\Controller\Pages;
use SebDru\Blog\Controller\Users;
use SebDru\Blog\Controller\Articles;
use SebDru\Blog\Controller\Comments;

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
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    if (!empty($_POST['comment'])) {
                        $commentsController ? null : $commentsController = new Comments();
                        $commentsController->addComment($_GET['id'], $_POST['comment']);
                    } else {
                        throw new Exception('Tous les champs ne sont pas remplis');
                    }
                } else {
                    throw new Exception('Aucun identifiant d\'article envoyé');
                }
                break;

            case 'login':
                if(!isset($_SESSION['pseudo'])){
                    $pagesController ? null : $pagesController = new Pages();
                    $pagesController->login();
                }
                break;

            case 'addUser':
                $usersController ? null : $usersController = new Users();
                $usersController->addUser($_POST);
                break;

            case 'connect':
                if (isset($_POST)){
                    $usersController ? null : $usersController = new Users();
                    $usersController->connect($_POST['pseudo'],$_POST['password']);
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
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $articlesController ? null : $articlesController = new Articles();
                    $articlesController->article();
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;


        }
    }else {
        $pagesController ? null : $pagesController = new Pages();
        $pagesController->landing();
    }

} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
