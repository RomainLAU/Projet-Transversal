<?php

namespace Mvc\Controller;

use Config\Controller;
use Twig\Environment;
use Mvc\Model\JourneyModel;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->journeyModel = new JourneyModel();
        parent::__construct();
    }

    public function displayAdmin() {

        echo $this->twig->render('admin/admin.html.twig');
    }

    public function listJourneys() {

        $journeys = $this->journeyModel->getJourneys();

        echo $this->twig->render('admin/adminJourneys.html.twig', [
            'journeys' => $journeys
        ]);

    }

}