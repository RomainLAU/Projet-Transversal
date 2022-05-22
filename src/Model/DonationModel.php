<?php

namespace Mvc\Model;

use Config\Model;

use PDO;

class DonationModel extends Model
{

    public function getDonations() {
        $statement = $this->pdo->prepare('SELECT * FROM `donations`');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addDonation($associationId, $amount) {

        $today = new \DateTime();

        $statement = $this->pdo->prepare('INSERT INTO `donations` (`user_id`, `association_id`, `date`, `amount`) VALUES (:user_id, :association_id, :date, :amount)');

        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
            'association_id' => $associationId,
            'date' => $today->format('Y-m-d H:i:s'),
            'amount' => $amount,
        ]);
    }

    public function deleteDonation($donationId) {
        $statement = $this->pdo->prepare('DELETE `donations` FROM `donations` WHERE `id` = :donation_id');

        $statement->execute([
            'donation_id' => $donationId,
        ]);
    }
}