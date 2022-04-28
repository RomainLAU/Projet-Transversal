<?php

namespace Mvc\Controller;

use Config\Controller;
use Twig\Environment;

class ProfileController extends Controller
{

    public function displayProfile() {
        
        echo $this->twig->render('/user/profile.html.twig');
    }
}