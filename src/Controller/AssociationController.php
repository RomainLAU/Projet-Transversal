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

        // dd($associations, $favoriteAssociations);

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

    public function deleteFromFavorites($associationId) {

        $favoriteAssociation = $this->associationModel->findFavoriteAssociation($associationId);

        $this->associationModel->deleteFavoriteAssociation($favoriteAssociation['id']);

        header('location: /account');
        exit();
    }
}