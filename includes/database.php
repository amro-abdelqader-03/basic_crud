<?php
require_once("config.php");

class Database
{
    private $db;
    public $conn;
    public function __construct()
    {
        $this->db = new Connect();
        $this->conn = $this->db->getConn();
    }

    public function addUser($username, $email, $password, $created_at)
    {
        $sql = "INSERT INTO users (username, email, password, created_at) VALUES 
        (?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            return $stmt->execute([$username, $email, $password, $created_at]);
        } else {
            return false;
        }
    }

    public function validateEmail($email)
    {
        $sql = "SELECT email FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }
        if ($stmt->execute([$email])) {
            $result = $stmt->rowCount();
            if ($result == 1) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function validateUsername($username)
    {
        global $conn;
        $sql = "SELECT username FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }

        if ($stmt->execute([$username])) {
            $result = $stmt->rowCount();
            if ($result == 1) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getUserByEmail($email)
    {
        $sql = "SELECT id, username, password FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            if ($stmt->execute([$email])) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        }
        return false;
    }

    public function getUsername($userID)
    {
        $sql = "SELECT username FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }
        if ($stmt->execute([$userID])) {
            return $stmt->fetch()["username"];
        }
        return false;
    }

    public function isAdmin($userID)
    {
        $sql = "SELECT role FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);

        if (!$stmt) {
            return false;
        }
        if ($stmt->execute([$userID])) {
            return $stmt->fetch()["role"] == "admin";
        }
        return false;
    }

    public function getAllUsers($userID)
    {
        $sql = "SELECT id, username, email, role FROM users WHERE NOT id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            if ($stmt->execute([$userID])) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return false;
    }

    public function deleteUser($userID)
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            return $stmt->execute([$userID]);
        }
        return false;
    }

    public function editUser($userID, $username, $email)
    {
        $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        if ($stmt) {
            return $stmt->execute([$username, $email, $userID]);
        }
        return false;
    }

}
?>