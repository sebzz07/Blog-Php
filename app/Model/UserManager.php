<?php

namespace SebDru\Blog\Model;

class UserManager
{

    public function getUserbyName(string $name)
    {
        $req = Manager::getInstance()->prepare(
            '
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
                ->setPassword($response['password'])
                ->setAdmin($response['admin']);

            return $user;
        }
    }

    public function getUserByEmail(string $email)
    {
        $req = Manager::getInstance()->prepare(
            '
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
                ->setPassword($response['password'])
                ->setAdmin($response['admin']);

            return $user;
        }
    }

    public function registerUser(User $user): User
    {

        $checkNameExist = $this->getUserbyName($user->getName());
        if (false != $checkNameExist) {
            throw new \Exception('Le nom est déjà utilisé');
        }

        $checkEmailExist = $this->getUserByEmail($user->getEmail());
        if (false != $checkEmailExist) {
            throw new \Exception("L'email a déjà été utilisé");
        }

        $req = Manager::getInstance()->prepare(
            '
        INSERT INTO user(name, email, password) 
        VALUES( :name, :email, :password )'
        );
        $name = $user->getName();
        $email = $user->getEmail();
        $pass = $user->getPassword();

        $req->bindParam(':name', $name, \PDO::PARAM_STR);
        $req->bindParam(':email', $email, \PDO::PARAM_STR);
        $req->bindParam(':password', $pass, \PDO::PARAM_STR);

        $req->execute();

        return $user;
    }

    public function checkPassword(int $userId, string $password): bool
    {
        $req = Manager::getInstance()->prepare(
            '
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
