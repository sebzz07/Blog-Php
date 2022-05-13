<?php

namespace SebDru\Blog\Model;

class UserManager extends Manager
{

    public function getUser($pseudo)
    {

        $user = $this->dbConnect->prepare('SELECT * FROM user WHERE pseudo = ?');
        $user->execute(array($pseudo));
        $response = $user->fetch(\PDO::FETCH_ASSOC);
        return $response;
    }
    public function addUser(string $pseudo, string $first_name, string $last_name, string $email, string $password, string $image_link, string $presentation) : bool
    {
        $userInformation = array( $pseudo, $first_name, $last_name, $email, $password, $image_link, $presentation);
        var_dump($userInformation);
        $user = $this->dbConnect->prepare('INSERT INTO user(pseudo, first_name, last_name, email, password, image_link, presentation) VALUES(?, ?, ?, ?, ?, ? ,? )');
        $affectedLines = $user->execute($userInformation);
        return $affectedLines;
    }
    public function checkPassword(string $userId, string $password) : bool
    {
        $user = $this->dbConnect->prepare('SELECT * FROM user WHERE id = ?');
        $user -> execute(array($userId));
        $response = $user->fetch();

        if( $response['password'] === $password){
            return true;
        } else {
            return false;
        }

    }
}
