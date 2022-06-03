<?php

namespace SebDru\Blog\Controller;

class Pages extends Controller
{
    public function index()
    {
        $this->twig->display('frontend/index.html.twig', ['session' => $_SESSION]);
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

    public function error(string $e)
    {
        $this->twig->display('frontend/404.html.twig', compact('e'));
    }
}
