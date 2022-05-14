<?php

namespace Mvc\Controller;

use Config\Controller;
use Mvc\Model\JourneyModel;
use Twig\Environment;

class JourneyController extends Controller
{
    private JourneyModel $journeyModel;

    public function __construct() {
        parent::__construct();
        $this->journeyModel = new JourneyModel();
    }

    public function listJourneys() {

        echo $this->twig->render('/journey/listJourneys.html.twig');
    }

    public function createJourney() {
        // if (isset($_POST['create']))
        
        dd($_POST);
    }
}