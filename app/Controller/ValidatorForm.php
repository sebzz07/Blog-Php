<?php

namespace SebDru\Blog\Controller;

use Exception;
use SebDru\Blog\Model\User;

class ValidatorForm
{

    public function validatorName(User $user): User
    {
        if ($user->getName() == null) {
            throw new Exception('Vous devez saisir un nom');
        }

        if (strlen($user->getName()) <= 6 && strlen($user->getName()) >= 50 && !preg_match('/^[a-zA-Z0-9_]+$/', $user->getName())) {
            throw new Exception("le nom n'est pas valide (caractères autorisées : lettres majuscules ou minuscules, chiffres et _) et doit avoir entre 6 et 50 caratères");
        }
        return $user;
    }

    public function validatorEmail(User $user): User
    {
        if (null == filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("L'email est manquant ou n'est pas au bon format");
        }
        return $user;
    }

    public function validatorPassword(User $user): User
    {
        if (empty($user->getPassword())) {
            throw new Exception('il manque un mot de passe');
        }
        if (!preg_match('/(?=.*[0-9])/', $user->getPassword())) {
            throw new Exception('Un chiffre doit être utilisé au moins une fois dans le mot de passe.');
        }
        if (!preg_match('/(?=.*[a-z])/', $user->getPassword())) {
            throw new Exception('Une minuscule doit être utilisée au moins une fois dans le mot de passe.');
        }
        if (!preg_match('/(?=.*[A-Z])/', $user->getPassword())) {
            throw new Exception('Une majuscule doit être utilisée au moins une fois dans le mot de passe.');
        }
        if (!preg_match('/(?=.*[@#$%^&-+=() ])/', $user->getPassword())) {
            throw new Exception('Un charatère spécial : @ # $ % ^ & - + = ( ) doit être utilisé au moins une fois dans le mot de passe.');
        }
        if (preg_match('/(?=\\s+)/', $user->getPassword())) {
            throw new Exception("Le mot de passe ne doit pas contenir d'espace.");
        }
        if (strlen($user->getPassword()) < 8) {
            throw new Exception('Le mot de passe doit avoir au moins 8 caractères.');
        }
        if (strlen($user->getPassword()) >= 128) {
            throw new Exception('Le mot de passe doit avoir moins de 128 caractères.');
        }

        if (empty($user->getPasswordConfirm()) || $user->getPassword() != $user->getPasswordConfirm()) {
            throw new Exception('Les deux mots de passe ne sont pas identiques');
        }
        return $user;
    }
}
