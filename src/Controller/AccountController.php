<?php

namespace Mvc\Controller;

use Config\Controller;
use Twig\Environment;
use Mvc\Model\JourneyModel;
use Mvc\Model\AssociationModel;

class AccountController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->journeyModel = new JourneyModel();
        $this->associationModel = new AssociationModel();
    }

    public function displayAccount() {

        $favoriteJourneys = $this->journeyModel->getFavoriteJourneysOfUser();
        $favoriteAssociations = $this->associationModel->getFavoriteAssociationsOfUser();
        
        echo $this->twig->render('/user/account.html.twig', [
            'favoriteJourneys' => $favoriteJourneys,
            'favoriteAssociations' => $favoriteAssociations,
        ]);
    }
}