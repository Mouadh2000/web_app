<?php

namespace App\Models;

use Core\BaseModel;
use PDO;

class UploadModel extends Database
{
    protected $table = 'cvs'; // Adjust table name as per your database setup

    public function insertUpload($userId, $fileName)
    {
        $stmt = $this->connection->prepare("INSERT INTO {$this->table} (user_id, file) VALUES (:user_id, :file)");
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':file', $fileName, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getAllCvsWithUserDetails()
    {
        $query = "SELECT cvs.id, admin.first_name, admin.last_name, admin.email, cvs.file 
                  FROM cvs 
                  INNER JOIN admin ON cvs.user_id = admin.id";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFileByFileName($fileName)
    {
        $stmt = $this->connection->prepare("SELECT * FROM {$this->table} WHERE file = :file");
        $stmt->bindParam(':file', $fileName, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCVsCount()
    {
        $query = "SELECT COUNT(*) AS count FROM cvs";
        $statement = $this->connection->prepare($query);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        return $result['count'];
    }
}
