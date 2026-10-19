<?php
require_once("database.php");
class Auth
{
    private $db;
    public function __construct()
    {
        $this->db = new Database();
    }

    public function registrer($username, $email, $password, $created_at)
    {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if ($this->db->addUser($username, $email, $hashed_password, $created_at)) {
            header("location: login.php");
            exit();
        } else {
            displayErr("Oops! Something went wrong. Please try again later.");
        }
    }

    public function login($email, $password)
    {
        $user = $this->db->getUserByEmail($email);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['userID'] = $user['id'];
                return true;
            }
        }
        return false;
    }
}
?>