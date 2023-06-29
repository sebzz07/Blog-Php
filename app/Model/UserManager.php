<?php

declare(strict_types=1);

namespace SebDru\Blog\Model;

class UserManager
{
    public function getUsers()
    {

        $req = Manager::getInstance()->prepare('SELECT 
        id, 
        name,
        email,
        status
        FROM user 
        ORDER BY status 
        DESC 
        ');
        $req->execute();
        return $req->fetchAll();
    }

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
                ->setStatus($response['status']);

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
                ->setStatus($response['status']);

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
        INSERT INTO user(name, email, password, status) 
        VALUES( :name, :email, :password, :status )'
        );
        $name = $user->getName();
        $email = $user->getEmail();
        $pass = $user->getPassword();
        $status = $user->getStatus();

        $req->bindParam(':name', $name, \PDO::PARAM_STR);
        $req->bindParam(':email', $email, \PDO::PARAM_STR);
        $req->bindParam(':password', $pass, \PDO::PARAM_STR);
        $req->bindParam(':status', $status, \PDO::PARAM_STR);
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

    public function updateStatus(User $user)
    {
        $req = Manager::getInstance()->prepare(
            'UPDATE user
            SET
            status=:status 
            WHERE id=:id
            '
        );
        $req->bindParam(':status', $user->getStatus(), \PDO::PARAM_STR);
        $req->bindParam(':id', $user->getId(), \PDO::PARAM_INT);
        $req->execute();
    }
}
