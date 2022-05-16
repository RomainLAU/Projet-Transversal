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

        $journeys = $this->journeyModel->getJourneys();

        echo $this->twig->render('/journey/listJourneys.html.twig', [
            'journeys' => $journeys,
        ]);
    }

    public function createJourney() {

        // dd($_POST);
        if (isset($_POST['postButton']) && isset($_POST['trajetType']) && isset($_POST['date']) && isset($_POST['place']) && isset($_POST['duration']) && isset($_POST['description']) && isset($_POST['tags'])) {

            $this->journeyModel->createJourney($_POST['trajetType'], $_POST['date'], $_POST['place'], $_POST['duration'], $_POST['description'], $_POST['tags']);
        }

        header('location: /journey');
        exit();
    }
}