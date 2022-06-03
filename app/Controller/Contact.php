<?php

namespace SebDru\Blog\Controller;

use SebDru\Blog\Model;

class Contact
{

    public function send()
    {

        $email = "sebdru.fr@gmail.com";
        $headers = 'From: ' . $email;


        return mail('sebzz13pub@gmail.com', 'test', "couou", $headers);
    }
}
