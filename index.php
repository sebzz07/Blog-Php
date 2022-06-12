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
                isset($articlesController) ? null : $articlesController = new Articles();
                if (isset($_SESSION['userInformation']['admin']) && $_SESSION['userInformation']['admin'] === 1) {
                    $articlesController->editListArticles($_SESSION);
                } else {
                    $articlesController->listArticles();
                }
                break;

            case 'article':
                isset($articlesController) ? null : $articlesController = new Articles();
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
                    isset($articlesController) ? null : $articlesController = new Articles();
                    $articlesController->createArticle($_SESSION);
                } else {
                    throw new Exception("Vous n'avez pas les droits");
                }
                break;

            case 'registerArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                $arg = $articlesController->filterInput($_POST);
                $articlesController->registerArticle($_SESSION, $arg);
                break;

            case 'editArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                if (isset($_SESSION) && $_SESSION['userInformation']['admin'] === 1) {
                    $arg = $articlesController->filterInput($_GET);

                    if (isset($arg['id']) && $arg['id'] > 0) {
                        $articlesController->EditArticle($_SESSION, $arg['id']);
                    } else {
                        throw new Exception("Aucun identifiant d'article envoyé");
                    }
                } else {
                    throw new Exception("Vous n'avez pas les droits");
                }
                break;

            case 'updateArticle':
                if (!isset($_SESSION['userInformation'])) {
                    throw new Exception("Vous n'avez pas les droits");
                }

                isset($articlesController) ? null : $articlesController = new Articles();
                $arg = $articlesController->filterInput($_GET);

                if (isset($arg['id']) && $arg['id'] > 0) {
                    $articlesController->updateArticle($arg['id'], $_POST);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'publishArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                $arg = $articlesController->filterInput($_GET);

                if (isset($arg['id']) && $arg['id'] > 0) {
                    $articlesController->publishArticle($arg['id']);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'unpublishArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                $arg = $articlesController->filterInput($_GET);

                if (isset($arg['id']) && $arg['id'] > 0) {
                    $articlesController->unpublishArticle($arg['id']);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'addComment':
                if (!isset($_SESSION['userInformation'])) {
                    throw new Exception("Vous n'avez pas les droits");
                }
                isset($commentsController) ? null : $commentsController = new Comments();
                $getFiltered = $commentsController->filterInput($_GET);
                $articleid = $getFiltered['id'];
                if (isset($articleid) && $articleid > 0) {
                    if (empty($_POST['comment'])) {
                        throw new Exception('Tous les champs ne sont pas remplis');
                    }
                    $commentsController->addComment($articleid, $_POST, $_SESSION);
                } else {
                    throw new Exception('Aucun identifiant d\'article envoyé');
                }
                break;

            case 'updateComment':
                if (!isset($_SESSION['userInformation'])) {
                    throw new Exception("Vous n'avez pas les droits");
                }
                isset($commentsController) ? null : $commentsController = new Comments();
                $getFiltered = $commentsController->filterInput($_GET);
                $commentId = $getFiltered['id'];
                if (isset($commentId) && $commentId > 0) {
                    $commentsController->updateComment($commentId, $_POST, $_SESSION);
                } else {
                    throw new Exception("Aucun identifiant de commentaire envoyé");
                }
                break;

            case 'PendingComments':
                isset($commentsController) ? null : $commentsController = new Comments();

                if (isset($_SESSION) && $_SESSION['userInformation']['admin'] === 1) {
                    $commentsController->listPendingComments();
                } else {
                    throw new Exception("Vous n'avez pas les droits");
                }
                break;

            case 'publishComment':
                isset($commentsController) ? null : $commentsController = new Comments();
                $arg = $commentsController->filterInput($_GET);

                if (isset($arg['id']) && $arg['id'] > 0) {
                    $commentsController->publishComment($arg['id']);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'unpublishComment':
                isset($commentsController) ? null : $commentsController = new Comments();
                $arg = $commentsController->filterInput($_GET);

                if (isset($arg['id']) && $arg['id'] > 0) {
                    $commentsController->unpublishComment($arg['id']);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;
        }
    } else {
        isset($pagesController) ? null : $pagesController = new Pages();
        $pagesController->index();
    }
} catch (Exception $e) {
    isset($pagesController) ? null : $pagesController = new Pages();
    $pagesController->error($e->getMessage() ? $e->getMessage() : null);
}
