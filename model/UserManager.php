<?php

namespace SebDru\Blog\Model;

class UserManager extends Manager
{

    public function getUser($userId)
    {
        $db = dbConnect();
        $user = $db->prepare('SELECT * FROM user WHERE id = ?');
        $user->execute(array($userId));

        return $user;
    }
}
