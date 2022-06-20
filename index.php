<?php

define('ROOT', __DIR__);

require_once 'vendor/autoload.php';

use SebDru\Blog\Controller\Pages;
use SebDru\Blog\Controller\Users;
use SebDru\Blog\Controller\Articles;
use SebDru\Blog\Controller\Comments;
use SebDru\Blog\Controller\SendAnEmail;
use SebDru\Blog\Controller\GlobalFilter;

session_start();
//  Routing
isset($globalGet) ? null : $globalGet = new GlobalFilter("get");
$action = $globalGet->filter('action');
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
                isset($usersController) ? null : $usersController = new Users();
                isset($globalPost) ? null : $globalPost = new GlobalFilter("post");
                $usersController->addUser($globalPost->filter());
                break;

            case 'editListUsers':
                if (isset($_SESSION) && $_SESSION['userInformation']['status'] == "admin") {
                    isset($usersController) ? null : $usersController = new Users();
                    $usersController->editListUsers();
                } else {
                    throw new Exception("Vous n'avez pas les droits");
                }
                break;

            case 'ValidateUser':
                if (!isset($_SESSION['userInformation']) or $_SESSION['userInformation']['status'] !== "admin") {
                    throw new Exception("Vous n'avez pas les droits");
                }

                isset($usersController) ? null : $usersController = new Users();
                $idUser = $globalGet->filter('id');
                if (null !== $idUser && $idUser > 0) {
                    $usersController->updateUser($globalGet->filter());
                } else {
                    throw new Exception("Aucun identifiant d'article valide envoyé");
                }
                break;

            case 'banishUser':
                if (!isset($_SESSION['userInformation']) or $_SESSION['userInformation']['status'] !== "admin") {
                    throw new Exception("Vous n'avez pas les droits");
                }
                isset($usersController) ? null : $usersController = new Users();
                $idUser = $globalGet->filter('id');
                if (null !== $idUser && $idUser > 0) {
                    $usersController->updateUser($globalGet->filter());
                } else {
                    throw new Exception("Aucun identifiant d'article valide envoyé");
                }
                break;

            case 'connect':
                isset($usersController) ? null : $usersController = new Users();

                isset($globalPost) ? null : $globalPost = new GlobalFilter("post");

                if (null !== $globalPost->filter('name') && null !== $globalPost->filter('password')) {
                    $usersController->connect($globalPost->filter('name'), $globalPost->filter('password'));
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
                if (isset($_SESSION['userInformation']['status']) && $_SESSION['userInformation']['status'] === "admin") {
                    $articlesController->editListArticles($_SESSION);
                } else {
                    $articlesController->listArticles();
                }
                break;

            case 'article':
                isset($articlesController) ? null : $articlesController = new Articles();
                $idArticle = $globalGet->filter('id');
                if (null !== $idArticle && $idArticle > 0) {
                    $articlesController->article($idArticle);
                } else {
                    throw new Exception("Aucun identifiant d'article valide envoyé");
                }
                break;

            case 'createArticle':
                if (isset($_SESSION) && $_SESSION['userInformation']['status'] === "admin") {
                    isset($articlesController) ? null : $articlesController = new Articles();
                    $articlesController->createArticle($_SESSION);
                } else {
                    throw new Exception("Vous n'avez pas les droits");
                }
                break;

            case 'registerArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                isset($globalPost) ? null : $globalPost = new GlobalFilter("post");
                $articlesController->registerArticle($_SESSION, $globalPost->filter());
                break;

            case 'editArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                if (isset($_SESSION) && $_SESSION['userInformation']['status'] === "admin") {

                    $idArticle = $globalGet->filter('id');
                    if (null !== $idArticle && $idArticle > 0) {
                        $articlesController->EditArticle($_SESSION, $idArticle);
                    } else {
                        throw new Exception("Aucun identifiant d'article valide envoyé");
                    }
                } else {
                    throw new Exception("Vous n'avez pas les droits");
                }
                break;

            case 'updateArticle':
                if (!isset($_SESSION['userInformation']) or $_SESSION['userInformation']['status'] !== 'admin') {
                    throw new Exception("Vous n'avez pas les droits");
                }

                isset($articlesController) ? null : $articlesController = new Articles();
                $idArticle = $globalGet->filter('id');
                if (null !== $idArticle && $idArticle > 0) {
                    $articlesController->updateArticle($idArticle, $globalPost->filter());
                } else {
                    throw new Exception("Aucun identifiant d'article valide envoyé");
                }
                break;

            case 'publishArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                $idArticle = $globalGet->filter('id');
                if (null !== $idArticle && $idArticle > 0) {
                    $articlesController->publishArticle($idArticle);
                } else {
                    throw new Exception("Aucun identifiant d'article valide envoyé");
                }
                break;

            case 'unpublishArticle':
                isset($articlesController) ? null : $articlesController = new Articles();
                $idArticle = $globalGet->filter('id');

                if (null !== $idArticle && $idArticle > 0) {
                    $articlesController->unpublishArticle($idArticle);
                } else {
                    throw new Exception("Aucun identifiant d'article valide envoyé");
                }
                break;

            case 'addComment':
                if (!isset($_SESSION['userInformation'])) {
                    throw new Exception("Vous devez vous connecter pour ajouter un commentaire");
                }
                isset($commentsController) ? null : $commentsController = new Comments();
                $idArticle = $globalGet->filter('id');
                if (null !== $idArticle && $idArticle > 0) {
                    isset($globalPost) ? null : $globalPost = new GlobalFilter("post");
                    if (null === $globalPost->filter('comment')) {
                        throw new Exception('Tous les champs ne sont pas remplis');
                    }
                    $commentsController->addComment($idArticle, $globalPost->filter(), $_SESSION);
                } else {
                    throw new Exception("Aucun identifiant d'article valide envoyé");
                }
                break;

            case 'updateComment':
                if (!isset($_SESSION['userInformation'])) {
                    throw new Exception("Vous n'avez pas les droits");
                }
                isset($commentsController) ? null : $commentsController = new Comments();
                $idComment = $globalGet->filter('id');
                if (null !== $idComment && $idComment > 0) {
                    isset($globalPost) ? null : $globalPost = new GlobalFilter("post");
                    $commentsController->updateComment($idComment, $globalPost->filter(), $_SESSION);
                } else {
                    throw new Exception("Aucun identifiant de commentaire valide envoyé");
                }
                break;

            case 'PendingComments':
                isset($commentsController) ? null : $commentsController = new Comments();

                if (isset($_SESSION) && $_SESSION['userInformation']['status'] === "admin") {
                    $commentsController->listPendingComments();
                } else {
                    throw new Exception("Vous n'avez pas les droits");
                }
                break;

            case 'publishComment':
                isset($commentsController) ? null : $commentsController = new Comments();
                $idComment = $globalGet->filter('id');
                if (null !== $idComment && $idComment > 0) {
                    $commentsController->publishComment($idComment);
                } else {
                    throw new Exception("Aucun identifiant d'article valide envoyé");
                }
                break;

            case 'unpublishComment':
                isset($commentsController) ? null : $commentsController = new Comments();
                $idComment = $globalGet->filter('id');

                if (null !== $idComment && $idComment > 0) {
                    $commentsController->unpublishComment($idComment);
                } else {
                    throw new Exception("Aucun identifiant d'article valide envoyé");
                }
                break;

            case 'sendContactEmail':
                $mail = new SendAnEmail();
                isset($globalPost) ? null : $globalPost = new GlobalFilter("post");
                $mail->sendmail($globalPost->filter());
        }
    } else {
        isset($pagesController) ? null : $pagesController = new Pages();
        $pagesController->index();
    }
} catch (Exception $e) {
    isset($pagesController) ? null : $pagesController = new Pages();
    $pagesController->error($e->getMessage() ? $e->getMessage() : null);
}
