<?php

namespace Mvc\Controller;

use Config\Controller;
use Mvc\Model\DonationModel;
use Twig\Environment;

// <!-- donateToAssociation -->

class DonationController extends Controller
{
    private DonationModel $donationModel;

    public function __construct() {
        parent::__construct();
        $this->donationModel = new DonationModel();
    }

    public function listAssociations() {

        $donations = $this->donationModel->getDonations();
    }

    public function donateToAssociation($associationId) {

        $this->donationModel->addDonation($associationId, $_POST['amount']);

        header('location: /association/' . $associationId);
        exit();
    }
}