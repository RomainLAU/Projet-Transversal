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

    public function deleteJourney($journeyId) {
        $this->journeyModel->deleteJourney($journeyId);

        header('location: /admin/journey');
        exit();
    }

    public function listAssociations() {

        $associations = $this->associationModel->getAssociations();

        echo $this->twig->render('admin/adminAssociations.html.twig', [
            'associations' => $associations
        ]);

    }

    public function deleteAssociation($associationId) {
        $this->associationModel->deleteAssociation($associationId);

        header('location: /admin/associations');
        exit();
    }

    public function listDonations() {

        $donations = $this->donationModel->getDonations();

        echo $this->twig->render('admin/adminDonations.html.twig', [
            'donations' => $donations
        ]);

    }

    public function deleteDonation($donationId) {
        $this->donationModel->deleteDonation($donationId);

        header('location: /admin/donations');
        exit();
    }

    public function listUsers() {

        $users = $this->userModel->getUsers();

        echo $this->twig->render('admin/adminUsers.html.twig', [
            'users' => $users
        ]);

    }

    public function deleteUser($userId) {
        $this->userModel->deleteUser($userId);

        header('location: /admin/users');
        exit();
    }
}