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
        $favoriteJourneys = $this->journeyModel->getFavoriteJourneys();

        if (!is_array($favoriteJourneys) || count($favoriteJourneys) == 0) {
            $favoriteJourneys = [
                'id' => 0,
                'user_id' => 0,
                'journey_id' => 0,
            ];
        }


        echo $this->twig->render('/journey/listJourneys.html.twig', [
            'journeys' => $journeys,
            'favoriteJourneys' => $favoriteJourneys,
        ]);
    }

    public function createJourney() {

        if (isset($_POST['postButton']) && isset($_POST['trajetType']) && isset($_POST['date']) && isset($_POST['place']) && isset($_POST['duration']) && isset($_POST['description']) && isset($_POST['tags'])) {

            $this->journeyModel->createJourney($_POST['trajetType'], $_POST['date'], $_POST['place'], $_POST['duration'], $_POST['description'], $_POST['tags']);
        }

        header('location: /journey');
        exit();
    }

    public function addJourneyToFavorites($journeyId) {

        $favoriteJourney = $this->journeyModel->findFavoriteJourney($journeyId);

        if (is_bool($favoriteJourney) && $favoriteJourney === false) {
            $this->journeyModel->addFavoriteJourney($journeyId);
        } else if (is_array($favoriteJourney) && count($favoriteJourney) > 0) {
            $this->journeyModel->deleteFavoriteJourney($favoriteJourney['id']);
        }

        header('location: /journey');
        exit();
    }
}