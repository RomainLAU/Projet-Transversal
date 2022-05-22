<?php

namespace Mvc\Controller;

use Config\Controller;
use Twig\Environment;
use Mvc\Model\AssociationModel;
use Mvc\Model\JourneyModel;
use Mvc\Model\DonationModel;
use Mvc\Model\UserModel;

class AdminController extends Controller
{

    private DonationModel $donationModel;
    private AssociationModel $associationModel;
    private JourneyModel $journeyModel;
    private UserModel $userModel;

    public function __construct()
    {
        parent::__construct();
        $this->journeyModel = new JourneyModel();
        $this->associationModel = new AssociationModel();
        $this->donationModel = new DonationModel();
        $this->userModel = new UserModel();
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

    public function listAssociations() {

        $associations = $this->associationModel->getAssociations();

        echo $this->twig->render('admin/adminAssociations.html.twig', [
            'associations' => $associations
        ]);

    }

    public function listDonations() {

        $donations = $this->donationModel->getDonations();

        echo $this->twig->render('admin/adminDonations.html.twig', [
            'donations' => $donations
        ]);

    }

    public function listUsers() {

        $users = $this->userModel->getUsers();

        echo $this->twig->render('admin/adminUsers.html.twig', [
            'users' => $users
        ]);

    }

}