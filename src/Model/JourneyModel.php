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

    public function getFavoriteJourneysOfUser() {
        $statement = $this->pdo->prepare('SELECT * FROM `user_has_favorite_journeys` INNER JOIN user ON user_id = user.id WHERE user.id = :session_id');
        $statement->execute([
            'session_id' => $_SESSION['user']['id'],
        ]);

        $favoriteJourneyIds = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        // dd($favoriteJourneyIds);
        // dd($statement);

        $favoriteJourneys = [];

        foreach($favoriteJourneyIds as $id) {
            $statement2 = $this->pdo->prepare('SELECT * FROM `journey` WHERE id = :id');
            $statement2->execute([
                'id' => $id['journey_id'],
            ]);
    
            $favoriteJourneys[] = $statement2->fetch(PDO::FETCH_ASSOC);
        }

        return $favoriteJourneys;
    }

    public function findFavoriteJourney($journeyId) {
        $statement = $this->pdo->prepare('SELECT * FROM `user_has_favorite_journeys` WHERE `user_id` = :user_id AND `journey_id` = :journey_id');
        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
            'journey_id' => $journeyId,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteFavoriteJourney($id) {

        $statement = $this->pdo->prepare('DELETE FROM `user_has_favorite_journeys` WHERE `id` = :id');
        $statement->execute([
            'id' => $id,
        ]);
    }

    public function addFavoriteJourney($journeyId) {
        $statement = $this->pdo->prepare('INSERT INTO `user_has_favorite_journeys` (`user_id`, `journey_id`) VALUES (:user_id, :journey_id)');
        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
            'journey_id' => $journeyId,
        ]);
    }

    public function journeyFilter($valideFilters) {

        $query = 'SELECT * FROM `journey` INNER JOIN journey_type ON journey_type_id = journey_type.id WHERE';

        $queriesToAdd = [];

        foreach($valideFilters as $filters => $filter) {
            if ($filters == 'globalSearch') {
                $queriesToAdd[] = '`journey_type`.type LIKE :filter OR `place` LIKE :filter OR `date` LIKE :filter OR `tags` LIKE :filter OR `description` LIKE :filter;';

                $queriesToAddLen = count($queriesToAdd) - 1;
                $counter = 0;
                foreach($queriesToAdd as $queryToAdd) {
                    if ($queriesToAddLen == $counter) {
                        $query .= $queryToAdd;
                    } else if (substr($queryToAdd, -1) == '"') {
                        $query .= $queryToAdd . ' AND';
                        $counter++;
                    } else if (substr($queryToAdd, -1) == '%') {
                        $query .= $queryToAdd;
                        $counter++;
                    }
                }
        
                $statement = $this->pdo->prepare($query);
        
                $statement->execute([
                    'filter' => "%$filter%",
                ]);

                return $statement->fetchAll(PDO::FETCH_ASSOC);

            } else if ($filters == 'around') {
                $queriesToAdd[] = ' `place` LIKE "%'. $filter .'%"';
            } else if ($filters == 'date') {
                $queriesToAdd[] = ' `date` LIKE "%'. $filter .'%"';
            } else if ($filters == 'start') {
                $queriesToAdd[] = ' `date` LIKE "%' . $filter .'%"';
            } else if ($filters == 'activity') {

                $queriesToAdd[] = ' `journey_type`.type LIKE "%';
                $activityLen = count($filter) - 1;
                $counter = 0;

                foreach($filter as $activities => $activity) {
                    if ($counter == $activityLen) {
                        $queriesToAdd[] = $activity . '%"';
                    } else {
                        $queriesToAdd[] = $activity . '%" OR `journey_type`.type LIKE "%';
                        $counter++;
                    }
                }
            } else if ($filters == 'vehicule') {
                $queriesToAdd[] = ' `tags` LIKE "%';
                $vehiculeLen = count($filter) - 1;
                $counter = 0;

                foreach($filter as $vehicules => $vehicule) {
                    if ($counter == $vehiculeLen) {
                        $queriesToAdd[] = $vehicule . '%"';
                    } else {
                        $queriesToAdd[] = $vehicule . '%" OR `tags` LIKE "%';
                        $counter++;
                    }
                }
            }
        }

        $queriesToAddLen = count($queriesToAdd) - 1;
        $counter = 0;
        foreach($queriesToAdd as $queryToAdd) {
            if ($queriesToAddLen == $counter) {
                $query .= $queryToAdd;
            } else if (substr($queryToAdd, -1) == '"') {
                $query .= $queryToAdd . ' AND';
                $counter++;
            } else if (substr($queryToAdd, -1) == '%') {
                $query .= $queryToAdd;
                $counter++;
            }
        }

        $statement = $this->pdo->prepare($query);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function joinJourney($journeyId) {

        $statement = $this->pdo->prepare('INSERT INTO `user_has_journey` (`user_id`, `journey_id`) VALUES (:user_id, :journey_id)');

        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
            'journey_id' => $journeyId,
        ]);
    }

    public function getJoinedJourneys() {
        $statement = $this->pdo->prepare('SELECT * FROM `user_has_journey` WHERE `user_id` = :user_id');

        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
}