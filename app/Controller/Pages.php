<?php

declare(strict_types=1);

namespace SebDru\Blog\Controller;

class Pages extends Controller
{
    public function index()
    {
        $this->twig->display('frontOffice/index.html.twig', ['session' => $_SESSION]);
    }

    public function about()
    {
        $this->twig->display('frontOffice/about.html.twig');
    }

    public function contact()
    {
        $this->twig->display('frontOffice/contact.html.twig');
    }

    public function registerUser()
    {
        $this->twig->display('frontOffice/register.html.twig');
    }

    public function login()
    {
        $this->twig->display('frontOffice/login.html.twig');
    }

    public function error(string $e)
    {
        $this->twig->display('frontOffice/404.html.twig', compact('e'));
    }
}
