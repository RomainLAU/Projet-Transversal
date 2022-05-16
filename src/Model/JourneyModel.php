<?php

namespace Mvc\Model;

use Config\Model;

use PDO;

class JourneyModel extends Model
{
    public function createJourney($trajetType, $date, $place, $duration, $description, $tags) {
        $statement = $this->pdo->prepare('INSERT INTO `journey` (`journey_type_id`, `date`, `duration`, `place`, `description`, `tags`) VALUES (:journey_type_id, :date, :duration, :place, :description, :tags)');

        $statement->execute([
            'journey_type_id' => $trajetType,
            'date' => $date,
            'duration' => $duration,
            'place' => $place,
            'description' => $description,
            'tags' => $tags,
        ]);
    }

    public function getJourneys() {
        $statement = $this->pdo->prepare('SELECT * FROM `journey`');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFavoriteJourneys() {
        $statement = $this->pdo->prepare('SELECT * FROM `user_has_favorite_journeys` WHERE `user_id` = :user_id');
        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findFavoriteJourney($journeyId) {
        $statement = $this->pdo->prepare('SELECT * FROM `user_has_favorite_journeys` WHERE `user_id` = :user_id AND `journey_id` = :journey_id');
        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
            'journey_id' => $journeyId,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteFavoriteJourney($favoriteId) {

        $statement = $this->pdo->prepare('DELETE FROM `user_has_favorite_journeys` WHERE `id` = :favoriteId');
        $statement->execute([
            'favoriteId' => $favoriteId,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function addFavoriteJourney($journeyId) {
        $statement = $this->pdo->prepare('INSERT INTO `user_has_favorite_journeys` (`user_id`, `journey_id`) VALUES (:user_id, :journey_id)');
        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
            'journey_id' => $journeyId,
        ]);
    }
}