<?php
require('controller/frontend.php');

//  Routing
try {


    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'listArticles') {
            listArticles();
        } elseif ($_GET['action'] == 'article') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                article();
            } else {
                throw new Exception('Aucun identifiant d\'article envoyé');
            }
        } elseif ($_GET['action'] == 'about') {
            about();
        } elseif ($_GET['action'] == 'contact') {
            contact();
        } elseif ($_GET['action'] == 'addComment') {
            if (isset($_GET['id']) && $_GET['id'] > 0) {
                if (!empty($_POST['author']) && !empty($_POST['comment'])) {
                    addComment($_GET['id'], $_POST['author'], $_POST['comment']);
                } else {
                    throw new Exception('Tous les champs ne sont pas remplis');
                }
            } else {
                throw new Exception('Aucun identifiant d\'article envoyé');
            }
        }
    } else {
        listArticles();
    }
} catch (Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}
