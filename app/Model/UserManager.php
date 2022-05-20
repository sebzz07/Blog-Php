<?php

namespace SebDru\Blog\Model;

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
            $user = new User(
            $response['id'],
            $response['name'],
            $response['email'],
            $response['password'],
            $response['admin']
        );

            return $user;
        }
    }

    public function registerUser(User $user): bool
    {
        $userInformation = [htmlspecialchars($user->getName()), htmlspecialchars($user->getEmail()), $user->getPassword()];


        $checkNameExist = $this->getUserbyName($userInformation[0]);

        if (false != $checkNameExist) {
            throw new \Exception('Le nom est déjà utilisé');
        }

        if (null == filter_var($userInformation[1], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception("L'email est manquant ou n'est pas au bon format");
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

        return $affectedLines;
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
}
