<?php

namespace SebDru\Blog\Controller;

require_once('vendor/autoload.php');

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        //Set repertory of views
        $this->loader = new \Twig\Loader\FilesystemLoader(ROOT . '/Blog-Php/view');
        
        //Set Twig environement
        $this->twig = new \Twig\Environment($this->loader, ['debug' => true]);
    }
}
