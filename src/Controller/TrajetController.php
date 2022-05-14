<?php

namespace Mvc\Controller;

use Config\Controller;
use Mvc\Model\TrajetModel;
use Twig\Environment;

class TrajetController extends Controller
{
    private TrajetModel $trajetModel;

    public function __construct() {
        parent::__construct();
        $this->trajetModel = new TrajetModel();
    }

    public function listTrajets() {

        echo $this->twig->render('/trajet/listTrajets.html.twig');
    }

    public function createTrajet() {
        // if (isset($_POST['create']))
        
        dd($_POST);
    }
}