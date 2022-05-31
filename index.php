<?php
define('ROOT',__DIR__);



require_once('app/autoload.php');
require_once('vendor/autoload.php');

use SebDru\Blog\Controller;
//  Routing
$controllerInstance = new Controller\Frontend();
try {


    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listArticles') {
            $controllerInstance->listArticles();
        } 
        
        elseif ($_GET['action'] == 'article') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                $controllerInstance->article();
            } else {
                throw new Exception('Aucun identifiant d\'article envoyé');
            }
        } elseif ($_GET['action'] == 'about') {
            $controllerInstance->about();

        } elseif ($_GET['action'] == 'contact') {
            $controllerInstance->contact();
        } elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    $controllerInstance->addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                } else {
                    throw new Exception('Tous les champs ne sont pas remplis');
                }
            } else {
                throw new Exception('Aucun identifiant d\'article envoyé');
            }
        }
    } else {
        $controllerInstance->listArticles();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
