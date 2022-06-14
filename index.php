<?php

define('ROOT', __DIR__);

// require_once('app/autoload.php');
require_once 'vendor/autoload.php';

use SebDru\Blog\Controller\Pages;
use SebDru\Blog\Controller\Users;
use SebDru\Blog\Global\GlobalGet;
use SebDru\Blog\Global\GlobalPost;
use SebDru\Blog\Controller\Contact;
use SebDru\Blog\Controller\Articles;
use SebDru\Blog\Controller\Comments;
use SebDru\Blog\Controller\SendAnEmail;

session_start();
//  Routing
isset($globalGet) ? null : $globalGet = new GlobalGet();
$action = $globalGet->getGET('action');
try {
    if (null !== $action) {
        switch ($action) {
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
                isset($globalPost) ? null : $globalPost = new GlobalPost();
                $usersController->addUser($globalPost->getPost());
                break;

            case 'connect':
                isset($usersController) ? null : $usersController = new Users();

                isset($globalPost) ? null : $globalPost = new GlobalPost();

                if (null !== $globalPost->getPOST('name') && null !== $globalPost->getPOST('password')) {
                    $usersController->connect($globalPost->getPOST('name'), $globalPost->getPOST('password'));
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
                $idArticle = $globalGet->getGET('id');
                if (null !== $idArticle && $idArticle > 0) {
                    $articlesController->article($idArticle);
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
                isset($globalPost) ? null : $globalPost = new GlobalPost();
                $articlesController->registerArticle($_SESSION, $globalPost->getPOST());
                break;

            case 'editArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                if (isset($_SESSION) && $_SESSION['userInformation']['admin'] === 1) {

                    $idArticle = $globalGet->getGET('id');
                    if (null !== $idArticle && $idArticle > 0) {
                        $articlesController->EditArticle($_SESSION, $idArticle);
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
                $idArticle = $globalGet->getGET('id');
                if (null !== $idArticle && $idArticle > 0) {
                    $articlesController->updateArticle($idArticle, $globalPost->getPOST());
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'publishArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                $idArticle = $globalGet->getGET('id');
                if (null !== $idArticle && $idArticle > 0) {
                    $articlesController->publishArticle($idArticle);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'unpublishArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                $idArticle = $globalGet->getGET('id');

                if (null !== $idArticle && $idArticle > 0) {
                    $articlesController->unpublishArticle($idArticle);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'addComment':
                if (!isset($_SESSION['userInformation'])) {
                    throw new Exception("Vous devez vous connecter pour ajouter un commentaire");
                }
                isset($commentsController) ? null : $commentsController = new Comments();
                $idArticle = $globalGet->getGET('id');
                if (null !== $idArticle && $idArticle > 0) {
                    isset($globalPost) ? null : $globalPost = new GlobalPost();
                    if (null === $globalPost->getPOST('comment')) {
                        throw new Exception('Tous les champs ne sont pas remplis');
                    }
                    $commentsController->addComment($idArticle, $globalPost->getPOST(), $_SESSION);
                } else {
                    throw new Exception('Aucun identifiant d\'article envoyé');
                }
                break;

            case 'updateComment':
                if (!isset($_SESSION['userInformation'])) {
                    throw new Exception("Vous n'avez pas les droits");
                }
                isset($commentsController) ? null : $commentsController = new Comments();
                $idComment = $globalGet->getGET('id');
                if (null !== $idComment && $idComment > 0) {
                    isset($globalPost) ? null : $globalPost = new GlobalPost();
                    $commentsController->updateComment($idComment, $globalPost->getPOST(), $_SESSION);
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
                $idComment = $globalGet->getGET('id');
                if (null !== $idComment && $idComment > 0) {
                    $commentsController->publishComment($idComment);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'unpublishComment':
                isset($commentsController) ? null : $commentsController = new Comments();
                $idComment = $globalGet->getGET('id');

                if (null !== $idComment && $idComment > 0) {
                    $commentsController->unpublishComment($idComment);
                } else {
                    throw new Exception("Aucun identifiant d'article envoyé");
                }
                break;

            case 'sendmail':
                $mail = new SendAnEmail();
                isset($globalPost) ? null : $globalPost = new GlobalPost();
                $mail->sendmail($globalPost->getPOST());
        }
    } else {
        isset($pagesController) ? null : $pagesController = new Pages();
        $pagesController->index();
    }
} catch (Exception $e) {
    isset($pagesController) ? null : $pagesController = new Pages();
    $pagesController->error($e->getMessage() ? $e->getMessage() : null);
}
