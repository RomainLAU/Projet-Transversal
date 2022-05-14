<?php

namespace Mvc\Model;

use Config\Model;

use PDO;

class JourneyModel extends Model
{
    public function createJourney() {
        $statement = $this->pdo->prepare('INSERT INTO `journey` (`journey_type_id`, `date`, `duration`, `place`, `description`, `tags`) VALUES (:journey_type_id, :date, :duration, :place, :description, :tags)');

        $statement->execute([
            'journey_type_id' => $journey_type_id,
            'date' => $date,
            'duration' => $duration,
            'place' => $place,
            'description' => $description,
            'tags' => $tags,
        ]);
    }
}