<?php

namespace SebDru\Blog\Model;

use SebDru\Blog\Model;
class UserManager extends Manager
{

    public function getUserbyName(string $name) 
    {
        $req = $this->dbConnect->prepare('
        SELECT * 
        FROM user 
        WHERE name = ?'
        );

        $req->execute(array($name));
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $req->fetch();

        
        if ($response == false){
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

    public function getUserByEmail(string $email)
    {
        $req = $this->dbConnect->prepare('
        SELECT * 
        FROM user 
        WHERE email = ?'
        );
        
        $req->execute(array($email));
        $req->setFetchMode(\PDO::FETCH_ASSOC);
        $response = $req->fetch();

        if ($response == false){
            return false;
        }else{
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

    public function addUser(string $name, string $email, string $password) : bool
    {
        $userInformation = array( htmlspecialchars($name), htmlspecialchars($email), password_hash( htmlspecialchars($password), PASSWORD_BCRYPT, ['cost'=>'10']));
        
        $req = $this->dbConnect->prepare('
        INSERT INTO user(name, email, password) 
        VALUES( ?, ?, ? )'
        );

        $affectedLines = $req->execute($userInformation);

        return $affectedLines;
    }

    public function checkPassword(int $userId, string $password) : bool
    {
        $req = $this->dbConnect->prepare('
        SELECT * 
        FROM user 
        WHERE id = ?'
    );

        $req -> execute(array($userId));
        $response = $req->fetch();

        if( password_verify($password, $response['password'])){
            return true;
        } else {
            return false;
        }

    }
}
