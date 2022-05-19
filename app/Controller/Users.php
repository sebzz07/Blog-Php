<?php

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;

class Users extends Controller
{
    public function connect(string $name, string $password)
    {
        $checkLogin = new Model\UserManager();
        $user = $checkLogin->getUserbyName($name);
        $checkPassword = $checkLogin->checkPassword($user->getId(), $password);
        
        if ($checkPassword === true) {
            
            $_SESSION = [ 'userInformation'=>[
                'id' => $user->getId(),
                'name' => $user->getName()
            ]];
            
            $this->twig->display('frontend/landing.html.twig', array('session' => $_SESSION));
        } else {
            $this->twig->display('frontend/login.html.twig', compact('name'));
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
        $errors =  array();
        extract($newUser);
        $userManager = new Model\UserManager();

        if (!empty($newUser)) {
            if (empty($newUser['name']) || preg_match('/?=^[a-zA-Z0-9_]+$/', $newUser['name'])) {
                $errors['name'] = "le nom n'est pas valide (caractères autorisées : lettres majuscules ou minuscules, chiffres et _)";
            } else {    
                $checkNameExist = $userManager->getUserbyName( $newUser['name'] );
                
                if($checkNameExist != false ) {
                    $errors['nameUsed'] = "Le nom a déjà été utilisé";
                }
            };
            if (empty(filter_var($newUser['email'], FILTER_VALIDATE_EMAIL))) {
                $errors['email'] = "L'email est manquant ou incorrect";
            } else{
                $checkEmailExist = $userManager->getUserByEmail( $newUser['email'] );
                if($checkEmailExist != false) {
                    $errors['emailUsed'] = "L'email a déjà été utilisé";
                }
            };


            if (empty($newUser['password'])) {
                $errors['passwordMiss'] = "il manque un Mot de passe";
            } else{

                if (empty(preg_match('/(?=.*[0-9])/', $newUser['password']))) {
                    $errors['passwordNumber'] = "Un chiffre doit être utilisé au moins une fois dans le mot de passe.";
                } 
                if (empty(preg_match('/(?=.*[a-z])/', $newUser['password']))) {
                    $errors['passwordLower'] = "Une minuscule doit être utilisée au moins une fois dans le mot de passe.";
                } 
                if (empty(preg_match('/(?=.*[A-Z])/', $newUser['password']))) {
                    $errors['passwordUpper'] = "Une majuscule doit être utilisée au moins une fois dans le mot de passe.";
                } 
                if (empty(preg_match('/(?=.[@#$%^&-+=()])/', $newUser['password']))) {
                    $errors['passwordSpecial'] = "Un charatère spécial : @ # $ % ^ & - + = ( ) doit être utilisé au moins une fois dans le mot de passe.";
                } 
                if (empty(preg_match('/(?=\\S)/', $newUser['password']))) {
                    $errors['passwordSpace'] = "/e mot de passe ne doit pas contenir d'espace.";
                } 
                if ( strlen($newUser['password']) <=8 ) {
                    $errors['passwordMinCar'] = "Le mot de passe doit avoir au moins 8 caractères.";
                }
                if ( strlen($newUser['password']) >= 128 ) {
                    $errors['passwordMaxCar'] = "Le mot de passe doit avoir moins de 128 caractères.";
                }
            } 

            if (empty($newUser['password_confirm'] || $newUser['password'] != $newUser['password_confirm'])) {
                $errors['password_confirm'] = "La confirmation du Mot de passe n'est pas identique";
            };
            
        };

        if ( empty($errors)) 
        {
            $addUser = $userManager->addUser($name, $email, $password);
            $creationSuccess = true;
            $this->twig->display('frontend/login.html.twig', compact('name', 'creationSuccess'));
        } else 
        {
            $this->twig->display('frontend/register.html.twig', compact('errors'));
        }
    }
}