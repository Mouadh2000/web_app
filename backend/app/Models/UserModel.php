<?php

namespace App\Models;

use PDO;

class UserModel extends Database {
    public function checkLogin($email, $password)
    {
        $hashedPassword = md5($password);
        $query = "SELECT id, email, password FROM admin WHERE email = ? and password = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $email);
        $statement->bindParam(2, $hashedPassword);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if ($user !== false) {
            return $user['id']; 
        }
        return false;
    }

    public function getUserById($userId) {
        $query = "SELECT id, email, first_name, last_name FROM admin WHERE id = ?";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $userId);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getRegistration($firstName, $lastName, $email, $password)
    {
        $hashedPassword = md5($password);
        $query = "INSERT INTO admin (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $statement = $this->connection->prepare($query);
        $statement->bindParam(1, $firstName);
        $statement->bindParam(2, $lastName);
        $statement->bindParam(3, $email);
        $statement->bindParam(4, $hashedPassword);
        
        return $statement->execute();
    }

    public function getUsers()
    {
        $query = "SELECT * from admin";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function UserCount()
    {
        $query = "SELECT COUNT(*) AS count FROM admin";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['count'];
    }
}
