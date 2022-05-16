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
}