<?php

namespace Mvc\Controller;

use Config\Controller;
use Twig\Environment;

class AccountController extends Controller
{

    public function displayAccount() {
        
        echo $this->twig->render('/user/account.html.twig');
    }
}