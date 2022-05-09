<?php

namespace SebDru\Blog\Model;

class UserManager extends Manager
{

    public function getUser($userId)
    {
        
        $user = $this->dbConnect->prepare('SELECT * FROM user WHERE id = ?');
        $user -> execute(array($userId));

        return $user;
    }
    public function addUser($userInformation)
    {
        $user = $this->dbConnect->prepare('INSERT INTO user(pseudo, first_name, last_name, email, password, admin, image_link, presentation) VALUES(?, ?, ?, ?, ?, ? ,? ,? )');
        $affectedLines = $user->execute($userInformation);
        return $affectedLines;
    }
}
