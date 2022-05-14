<?php

namespace SebDru\Blog\Controller;

class Pages extends Controller
{
    
    public function landing()
    {
        $this->twig->display('frontend/landing.html.twig', array('session' => $_SESSION));
    }

    public function about()
    {
        $this->twig->display('frontend/about.html.twig');
    }

    public function contact()
    {
        $this->twig->display('frontend/contact.html.twig');
    }
    public function registerUser()
    {
        $this->twig->display('frontend/register.html.twig');
    }

    public function login()
    {
        $this->twig->display('frontend/login.html.twig');
    }

}