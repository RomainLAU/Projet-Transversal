<?php

namespace Mvc\Controller;

use Config\Controller;
use Mvc\Model\AssociationModel;
use Twig\Environment;

class AssociationController extends Controller
{
    private AssociationModel $associationModel;

    public function __construct() {
        parent::__construct();
        $this->associationModel = new AssociationModel();
    }

    public function listAssociations() {

        $associations = $this->associationModel->getAssociations();
        $favoriteAssociations = $this->associationModel->getFavoriteAssociations();

        if (!is_array($favoriteAssociations) || count($favoriteAssociations) == 0) {
            $favoriteAssociations = [
                'id' => 0,
                'user_id' => 0,
                'association_id' => 0,
            ];
        }

        echo $this->twig->render('/association/listAssociations.html.twig', [
            'associations' => $associations,
            'favoriteAssociations' => $favoriteAssociations,
        ]);
    }

    public function addAssociationToFavorites($associationId) {

        $favoriteAssociation = $this->associationModel->findFavoriteAssociation($associationId);
        
        if (is_bool($favoriteAssociation) && $favoriteAssociation === false) {
            $this->associationModel->addFavoriteAssociation($associationId);
        } else if (is_array($favoriteAssociation) && count($favoriteAssociation) > 0) {
            $delete = $this->associationModel->deleteFavoriteAssociation($favoriteAssociation['id']);
        }

        header('location: /associations');
        exit();
    }

    public function filterAssociations() {

        $filter = strtolower($_POST['globalSearch']);


        $filteredAssociations = $this->associationModel->associationFilter($filter);
        $favoriteAssociations = $this->associationModel->getFavoriteAssociations();

        echo $this->twig->render('/association/listAssociations.html.twig', [
            'associations' => $filteredAssociations,
            'favoriteAssociations' => $favoriteAssociations,
        ]);
    }
    
    public function showAssociationById($id) {

        $newJourneyCreated = false;

        if (isset($_POST['postButton']) && isset($_POST['trajetType']) && isset($_POST['date']) && strlen($_POST['date']) == 16 && isset($_POST['place']) && strlen($_POST['place']) > 0 && isset($_POST['duration'])  && strlen($_POST['place']) > 2 && isset($_POST['description']) && isset($_POST['tags'])) {

            $this->journeyModel->createJourney($_POST['trajetType'], $_POST['date'], $_POST['place'], $_POST['duration'], $_POST['description'], $_POST['tags']);

            $newJourneyCreated = true;
        }

        $association = $this->associationModel->getAssociationById($id);

        echo $this->twig->render('/association/association.html.twig', [
            'association' => $association,
            'donated' => false,
        ]);
    }

    public function deleteFromFavorites($associationId) {

        $favoriteAssociation = $this->associationModel->findFavoriteAssociation($associationId);

        $this->associationModel->deleteFavoriteAssociation($favoriteAssociation['id']);

        header('location: /account');
        exit();
    }
}