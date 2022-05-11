<?php

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;

class Frontend extends Controller
{
    
    
    public function listArticles()
    {
        $articleManager = new Model\ArticleManager();
        $articles = $articleManager->getArticles();

        $this->twig->display('frontend/listArticlesView.html.twig', compact('articles'));
    }

    public function article()
    {
        $articleManager = new Model\ArticleManager();
        $commentManager = new Model\CommentManager();

        $article = $articleManager->getItem($_GET['id']);
        $comments = $commentManager->getCommentsOfArticle($_GET['id']);

        $this->twig->display('frontend/articleView.html.twig', compact('article','comments'));
    }

    public function addComment(string $articleId, string $content)
    {
        $commentManager = new Model\CommentManager();
        $affectedLines = $commentManager->postComment($articleId, $content);

        if ($affectedLines === false) {
            throw new \Exception('Impossible d\'ajouter le commentaire !');
        } else {
            header('Location: index.php?action=article&id=' . $articleId);
        }
    }

    public function about()
    {
        $this->twig->display('frontend/about.html.twig');
    }

    public function contact()
    {
        $this->twig->display('frontend/contact.html.twig');
    }
    public function registerUser()
    {
        $this->twig->display('frontend/register.html.twig');
    }

    public function login()
    {
        $this->twig->display('frontend/login.html.twig');
    }

    public function connect(string $pseudo, string $password)
    {
        $checkLogin = new Model\UserManager();
        $user = $checkLogin->getUser($pseudo);
        $checkPassword = $checkLogin->checkPassword( $user['id'], $password);
        
        if($checkPassword === true) {
            session_start();
            $_SESSION = $user;
            $this->twig->display('frontend/landing.html.twig', array('session' => $_SESSION));
        }else{
            $this->twig->display('frontend/login.html.twig', compact('pseudo'));
        }
    }

    public function disconnect() 
    {
        session_destroy();
        $this->twig->display('frontend/landing.html.twig');
    }

    public function addUser( array $newUser)
    {
        function debug($variable){
    echo '<pre>'. print_r($variable,true) . '</pre>';
}
debug($newUser);

if( !empty($newUser) ) 
{
    $errors =  array();
    
    if( empty( $newUser['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/',$newUser['pseudo'] ))
    {
        $errors['pseudo'] = "le Pseudo n'est pas valide (caractères autorisées : lettres majuscules ou minuscules, chiffres et _)";
    };
        
    if( empty( $newUser['first_name'] ))
    {
        $errors['first_name'] = "il manque un Prénom";
    };    
    if( empty($newUser['last_name'] ))
    {
        $errors['last_name'] = "il manque un Nom";
    };    
    if( empty( filter_var( $newUser['email'], FILTER_VALIDATE_EMAIL)))
    {
        var_dump($newUser['email']);
        $errors['email'] = "L\'email est manquant ou incorrect";
    };    
    if( empty( $newUser['password'] ))
    {
        $errors['password'] = "il manque un Mot de passe";
    };    
    if( empty( $newUser['password_confirm'] || $newUser['password'] === $newUser['password_confirm'] )){
        $errors['password_confirm'] = "La confirmation du Mot de passe n'a pas fonctionné";
    };

    debug($errors);
};
        extract($newUser);
        $image_link = '';
        $userManager = new Model\UserManager();
        $addUser = $userManager->addUser($pseudo, $first_name, $last_name, $email, $password, $image_link, $presentation);

        
    }
}
