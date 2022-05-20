<?php

namespace Mvc\Controller;

use Config\Controller;
use Mvc\Model\DonationModel;
use Mvc\Model\AssociationModel;
use Twig\Environment;

class DonationController extends Controller
{
    private DonationModel $donationModel;
    private AssociationModel $associationModel;

    public function __construct() {
        parent::__construct();
        $this->donationModel = new DonationModel();
        $this->associationModel = new AssociationModel();
    }

    public function listAssociations() {

        $donations = $this->donationModel->getDonations();
    }

    public function donateToAssociation($associationId) {

        $this->donationModel->addDonation($associationId, $_POST['amount']);

        $association = $this->associationModel->getAssociationById($associationId);

        echo $this->twig->render('/association/association.html.twig', [
            'association' => $association,
            'donated' => true,
        ]);
    }
}