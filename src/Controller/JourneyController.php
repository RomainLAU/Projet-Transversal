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

        $newJourneyCreated = false;

        if (isset($_POST['postButton']) && isset($_POST['trajetType']) && isset($_POST['date']) && strlen($_POST['date']) == 16 && isset($_POST['place']) && strlen($_POST['place']) > 0 && isset($_POST['duration'])  && strlen($_POST['place']) > 2 && isset($_POST['description']) && isset($_POST['tags'])) {

            $this->journeyModel->createJourney($_POST['trajetType'], $_POST['date'], $_POST['place'], $_POST['duration'], $_POST['description'], $_POST['tags']);

            $newJourneyCreated = true;
        }

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
            'newJourneyCreated' => $newJourneyCreated,
        ]);
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

    public function filterJourneys() {

        $validFilters = [];

        foreach ($_POST as $filters => $filter) {
            if (is_string($filter) && strlen($filter) > 0) {
                $validFilters[$filters] = strtolower($filter);
            } else if (is_array($filter) && count($filter) > 0) {
                foreach($filter as $values => $value) {
                    $validFilters[$filters][] = strtolower($value);
                }
            }
        }

        if (count($validFilters) > 0) {
            $filteredJourneys = $this->journeyModel->journeyFilter($validFilters);
            $favoriteJourneys = $this->journeyModel->getFavoriteJourneys();

            echo $this->twig->render('/journey/listJourneys.html.twig', [
                'journeys' => $filteredJourneys,
                'favoriteJourneys' => $favoriteJourneys,
            ]);
        } else {
            $journeys = $this->journeyModel->getJourneys();
            $favoriteJourneys = $this->journeyModel->getFavoriteJourneys();

            if (!is_array($favoriteJourneys) || count($favoriteJourneys) == 0) {
                $favoriteJourneys = [
                    'id' => 0,
                    'user_id' => 0,
                    'journey_id' => 0,
                ];
            }
    
            $newJourneyCreated = false;
    
            echo $this->twig->render('/journey/listJourneys.html.twig', [
                'journeys' => $journeys,
                'favoriteJourneys' => $favoriteJourneys,
                'newJourneyCreated' => $newJourneyCreated,
            ]);
        }
    }

    public function deleteFromFavorites($favoriteJourney) {

        $this->journeyModel->deleteFavoriteJourney($favoriteJourney);

        header('location: /account');
        exit();
    }
}