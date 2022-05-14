<?php

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;

class Users extends Controller
{
    public function connect(string $pseudo, string $password)
    {
        $checkLogin = new Model\UserManager();
        $user = $checkLogin->getUser($pseudo);
        $checkPassword = $checkLogin->checkPassword($user['id'], $password);
        
        if ($checkPassword === true) {
            
            $_SESSION = [ 'userInformation'=>[
                'id' => $user['id'],
                'pseudo' =>$user['pseudo']
            ]];
            
            $this->twig->display('frontend/landing.html.twig', array('session' => $_SESSION));
        } else {
            $this->twig->display('frontend/login.html.twig', compact('pseudo'));
        }
    }

    public function disconnect()
    {
        unset($_SESSION['userInformation']);
        session_destroy();
        $this->twig->display('frontend/landing.html.twig', array('session' => $_SESSION));
    }

    public function addUser(array $newUser)
    {

        if (!empty($newUser)) {
            $errors =  array();
    
            if (empty($newUser['pseudo']) || !preg_match('/^[a-zA-Z0-9_]+$/', $newUser['pseudo'])) {
                $errors['pseudo'] = "le Pseudo n'est pas valide (caractères autorisées : lettres majuscules ou minuscules, chiffres et _)";
            };
        
            if (empty($newUser['first_name'])) {
                $errors['first_name'] = "il manque un Prénom";
            };
            if (empty($newUser['last_name'])) {
                $errors['last_name'] = "il manque un Nom";
            };
            if (empty(filter_var($newUser['email'], FILTER_VALIDATE_EMAIL))) {
                $errors['email'] = "L'email est manquant ou incorrect";
            };
            if (empty($newUser['password'])) {
                $errors['password'] = "il manque un Mot de passe";
            };
            if (empty($newUser['password_confirm'] || $newUser['password'] === $newUser['password_confirm'])) {
                $errors['password_confirm'] = "La confirmation du Mot de passe n'a pas fonctionné";
            };
        };

        if ( empty($errors)) 
        {
            extract($newUser);
            $image_link = '';
            $userManager = new Model\UserManager();
            $addUser = $userManager->addUser($pseudo, $first_name, $last_name, $email, $password, $image_link, $presentation);
            $this->twig->display('frontend/login.html.twig', compact('pseudo'));
        }else 
        {
            $this->twig->display('frontend/register.html.twig', compact('errors'));
        }
    }
}