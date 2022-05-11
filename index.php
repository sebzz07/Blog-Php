<?php
define('ROOT',__DIR__);



require_once('app/autoload.php');
require_once('vendor/autoload.php');

use SebDru\Blog\Controller;
//  Routing
$controllerInstance = new Controller\Frontend();
try {



    if (isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'listArticles':
                $controllerInstance->listArticles();
                break;
            case 'article':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    $controllerInstance->article();
                } else {
                    throw new Exception('Aucun identifiant d\'article envoyé');
                }
                break;
            case 'about':
                $controllerInstance->about();
                break;
            case 'contact':
                $controllerInstance->contact();
                break;
            case 'registerUser':
                    $controllerInstance->registerUser();
                    break;
            case 'addComment':
                if (isset($_GET['id']) && $_GET['id'] > 0) {
                    var_dump($_POST);
                    if (!empty($_POST['comment'])) {
                        $controllerInstance->addComment($_GET['id'], $_POST['comment']);
                    } else {
                        throw new Exception('Tous les champs ne sont pas remplis');
                    }
                } else {
                    throw new Exception('Aucun identifiant d\'article envoyé');
                }
                break;
            case 'login':
                if(!isset($_SESSION)){
                    $controllerInstance->login();
                    break;
                }
            case 'addUser':
                var_dump($_POST);
                $controllerInstance->addUser($_POST);
                break;
            case 'connect':
                if (isset($_POST)){
                    $controllerInstance->connect($_POST['pseudo'],$_POST['password']);
                    break;
                }
                case 'disconnect':
                    $controllerInstance->disconnect();
                    break;
        }
    }else {
        $controllerInstance->listArticles();
    }

} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
