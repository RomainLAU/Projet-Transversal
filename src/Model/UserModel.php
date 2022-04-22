<?php

namespace Mvc\Model;

use Config\Model;

use PDO;

class UserModel extends Model
{

    public function createUser(string $pseudo, string $lastname, string $firstname, string $mail, string $password) 
    {

        $statement = $this->pdo->prepare('INSERT INTO `user` (`pseudo`, `lastname`, `firstname`, `mail`, `password`, `timeRole`) VALUES (:pseudo, :lastname, :firstname, :mail, :password, :timeRole)');

        $statement->execute([
            'pseudo' => $pseudo,
            'lastname' => $lastname,
            'firstname' => $firstname,
            'mail' => $mail,
            'password' => $password,
            'timeRole' => 0,
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


    public function buyToken(int $token, String $firstname, int $amount ) {
        $statement = $this->pdo->prepare('UPDATE `user` SET `token` = :token + :ammount WHERE `firstname` = :firstname ');

        $statement->execute([
            'token' => $token,
            'firstname' => $firstname,
            'ammount' => $amount,
        ]);
        $_SESSION["user"]["token"] = $_SESSION["user"]["token"] + $amount; 
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function spendToken(int $token, String $firstname) {
        $statement = $this->pdo->prepare('UPDATE `user` SET `token` = :token  WHERE `firstname` = :firstname ');

        $statement->execute([
            'token' => $token,
            'firstname' => $firstname,
        ]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function buyHost() {

        $statement = $this->pdo->prepare('UPDATE `user` SET `role` = :role, `token` = :token, `timeRole`= :timeRole WHERE `id` = :id');

        $statement->execute([
            'role' => 'host',
            'token' => intval($_SESSION['user']['token']) - 1000,
            'id' => $_SESSION['user']['id'],
            'timeRole' => date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"))),
        ]);

        $_SESSION["user"]["timeRole"] = date("Y-m-d", mktime(0, 0, 0, date("m") + 1, date("d"), date("Y"))); 
    }

    public function changeRole() {

        $statement = $this->pdo->prepare('UPDATE `user` SET `role` = :role, `timeRole`= :timeRole WHERE `id` = :id');
        $statement->execute([
            'role' => "user",
            'id' => $_SESSION['user']['id'], 
            'timeRole' => '0',
        ]);
    }
}