<?php

namespace Mvc\Controller;

use Config\Controller;
use Twig\Environment;

class AccueilController extends Controller
{

    public function displayAccueil() {

        // dd($_SESSION);
        
        echo $this->twig->render('accueil.html.twig');
    }
}