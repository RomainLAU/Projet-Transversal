<?php

namespace Mvc\Controller;

use Config\Controller;
use Twig\Environment;
use Mvc\Model\JourneyModel;

class AccountController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->journeyModel = new JourneyModel();
    }

    public function displayAccount() {

        $favoriteJourneys = $this->journeyModel->getFavoriteJourneysOfUser();

        // dd($favoriteJourneys);
        
        echo $this->twig->render('/user/account.html.twig', [
            'favoriteJourneys' => $favoriteJourneys,
        ]);
    }
}