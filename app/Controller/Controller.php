<?php

namespace SebDru\Blog\Controller;

/**
 * Undocumented class.
 */
abstract class Controller
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        // Set repertory of views
        $this->loader = new \Twig\Loader\FilesystemLoader(ROOT . '/view');

        // Set Twig environement
        $this->twig = new \Twig\Environment($this->loader, [
            'debug' => true,
            'cache' => false,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());

        $this->twig->addGlobal('session', $_SESSION);
    }

    public function filterInput($value)
    {
        if (is_array($value)) {
            return array_map(fn ($value) => htmlspecialchars($value), $value);
        } else {
            return htmlspecialchars($value);
        }
    }
}
