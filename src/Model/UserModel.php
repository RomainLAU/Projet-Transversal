<?php

namespace Mvc\Model;

use Config\Model;

use PDO;

class UserModel extends Model
{

    public function createUser(string $lastname, string $firstname, string $mail, string $password) 
    {

        $statement = $this->pdo->prepare('INSERT INTO `user` (`lastname`, `firstname`, `mail`, `password`, `beez`) VALUES (:lastname, :firstname, :mail, :password, :beez)');

        $statement->execute([
            'lastname' => $lastname,
            'firstname' => $firstname,
            'mail' => $mail,
            'password' => $password,
            'beez' => 0,
        ]);
    }

    public function loginIn(string $mail) {

        $statement = $this->pdo->prepare('SELECT * FROM `user` WHERE `mail` = :mail');

        $statement->execute([
            'mail' => $mail,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function findUserById($id) 
    {
        $statement = $this->pdo->prepare('SELECT * FROM `user` WHERE `id` = :id');

        $statement->execute([
            'id' => $id,
        ]);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getUsers() {
        $statement = $this->pdo->prepare('SELECT * FROM `user`');

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($userId) {
        $statement = $this->pdo->prepare('DELETE `user` FROM `user` WHERE `id` = :user_id');

        $statement->execute([
            'user_id' => $userId,
        ]);
    }
}