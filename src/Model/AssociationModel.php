<?php

namespace Mvc\Model;

use Config\Model;

use PDO;

class AssociationModel extends Model
{

    public function getAssociations() {
        $statement = $this->pdo->prepare('SELECT * FROM `associations`');
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAssociationById($id) {
        $statement = $this->pdo->prepare('SELECT * FROM `associations` WHERE `id` = :id');
        $statement->execute([
            'id' => $id,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getFavoriteAssociations() {
        $statement = $this->pdo->prepare('SELECT * FROM `user_has_favorite_associations` WHERE `user_id` = :user_id');
        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
        ]);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFavoriteAssociationsOfUser() {
        $statement = $this->pdo->prepare('SELECT * FROM `user_has_favorite_associations` INNER JOIN user ON `user_id` = `user`.id WHERE `user`.id = :session_id');
        $statement->execute([
            'session_id' => $_SESSION['user']['id'],
        ]);

        $favoriteAssociationIds = $statement->fetchAll(PDO::FETCH_ASSOC);

        // dd($statement);

        $favoriteAssociations = [];

        foreach($favoriteAssociationIds as $id) {
            $statement2 = $this->pdo->prepare('SELECT * FROM `associations` WHERE id = :id');
            $statement2->execute([
                'id' => $id['association_id'],
            ]);
    
            $favoriteAssociations[] = $statement2->fetch(PDO::FETCH_ASSOC);
        }

        return $favoriteAssociations;
    }

    public function findFavoriteAssociation($associationId) {
        $statement = $this->pdo->prepare('SELECT * FROM `user_has_favorite_associations` WHERE `user_id` = :user_id AND `association_id` = :association_id');
        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
            'association_id' => $associationId,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteFavoriteAssociation($id) {

        $statement = $this->pdo->prepare('DELETE FROM `user_has_favorite_associations` WHERE `id` = :id');
        $statement->execute([
            'id' => $id,
        ]);
    }

    public function addFavoriteAssociation($associationId) {
        $statement = $this->pdo->prepare('INSERT INTO `user_has_favorite_associations` (`user_id`, `association_id`) VALUES (:user_id, :association_id)');
        $statement->execute([
            'user_id' => $_SESSION['user']['id'],
            'association_id' => $associationId,
        ]);
    }

    public function associationFilter($filter) {

        $statement = $this->pdo->prepare('SELECT * FROM `associations` WHERE `name` LIKE :filter OR `sector` LIKE :filter OR `firsttext` LIKE :filter OR `secondtext` LIKE :filter');

        $statement->execute([
            'filter' => "%$filter%",
        ]);
                
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }
}