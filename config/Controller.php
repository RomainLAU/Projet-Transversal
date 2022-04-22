<?php

namespace Config;

use Twig\Environment;

class Controller
{
    protected Environment $twig;

    public function __construct()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../src/View');
        $this->twig = new \Twig\Environment($loader);

        $this->twig->addGlobal('session', $_SESSION);
    }
}