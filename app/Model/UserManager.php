<?php

namespace SebDru\Blog\Model;

use Exception;

class UserManager extends Manager
{
    public function getUserbyName(string $name)
    {
        $req = $this->dbConnect->prepare('
        SELECT * 
        FROM user 
        WHERE name = ?'
        );

        $req->execute([$name]);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $req->fetch();

        if (false == $response) {
            return false;
        } else {
            $user = new User;
            $user->setId($response['id'])
            ->setName($response['name'])
            ->setEmail($response['email'])
            ->setPassword($response['password']);
            
            return $user;
        }
    }

    public function getUserByEmail(string $email)
    {
        $req = $this->dbConnect->prepare('
        SELECT * 
        FROM user 
        WHERE email = ?'
        );

        $req->execute([$email]);
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $req->fetch();

        if (false == $response) {
            return false;
        } else {
            $user = new User;
            $user->setId($response['id'])
            ->setName($response['name'])
            ->setEmail($response['email'])
            ->setPassword($response['password']);
            
            return $user;
        }
    }

    public function registerUser(User $user): User
    {
        $userInformation = [htmlspecialchars($user->getName()), htmlspecialchars($user->getEmail()), htmlspecialchars($user->getPassword())];


        $checkNameExist = $this->getUserbyName($userInformation[0]);

        if (false != $checkNameExist) {
            throw new \Exception('Le nom est déjà utilisé');
        }
        
        $checkEmailExist = $this->getUserByEmail($userInformation[1]);

        if (false != $checkEmailExist) {
            throw new \Exception("L'email a déjà été utilisé");
        }

        $req = $this->dbConnect->prepare('
        INSERT INTO user(name, email, password) 
        VALUES( ?, ?, ? )'
        );

        $affectedLines = $req->execute($userInformation);

        $user = new User;
        $user->setId($affectedLines['id'])
        ->setName($affectedLines['name'])
        ->setEmail($affectedLines['email'])
        ->setPassword($affectedLines['password']);
            
        return $user;
    }

    public function checkPassword(int $userId, string $password): bool
    {
        $req = $this->dbConnect->prepare('
        SELECT * 
        FROM user 
        WHERE id = ?'
    );

        $req->execute([$userId]);
        $response = $req->fetch();

        if (password_verify($password, $response['password'])) {
            return true;
        } else {
            return false;
        }
    }

    public function validatorName( User $user): User
    {
        if ($user->getName() == null ) {
            throw new Exception('Vous devez saisir un nom');
        }

        if (strlen($user->getName()) <= 6 && strlen($user->getName()) >= 50 && !preg_match('/^[a-zA-Z0-9_]+$/', $user->getName())) {
            throw new Exception("le nom n'est pas valide (caractères autorisées : lettres majuscules ou minuscules, chiffres et _) et doit avoir entre 6 et 50 caratères");
        }

        return $user;
    }

    public function validatorEmail( User $user) : User
    {
        if (null == filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("L'email est manquant ou n'est pas au bon format");
        }
        return $user;
    }

    public function validatorPassword(User $user) : User
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
        if (empty($user->getPasswordConfirm() || $user->getPassword() != $user->getPasswordConfirm())) {
            throw new Exception('Les deux mots de passe ne sont pas identiques');
        }

        return $user;
    }
}
