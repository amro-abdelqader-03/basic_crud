<?php
function displayErr($msg)
{
    echo "<p>" . htmlspecialchars($msg) . "</p>";
}

function validateEmail($email)
{
    global $conn;
    $sql = "SELECT email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bindParam("s", $email);
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

function validateUsername($username)
{
    global $conn;
    $sql = "SELECT username FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    $stmt->bindParam("s", $username);
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

function registrer($username, $email, $password, $created_at)
{
    global $conn;
    $sql = "INSERT INTO users (username, email, password, created_at) VALUES 
        (?,?,?,?)";
    $stmt = $conn->prepare($sql);
    if($stmt) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $check = $stmt->execute([$username, $email, $hashed_password, $created_at]);
        if ($check) {
            header("location: login.php");
            exit();
        } else {
            displayErr("Oops! Something went wrong. Please try again later.");
        }
    }
}


function login($email, $password)
{
    global $conn;

    $sql = "SELECT username, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }

    if (!$stmt->execute([$email])) {
        return false;
    }

    $user = $stmt->fetch();

    if (!$user) {
        return false;
    }

    if (password_verify($password, $user['password'])) {
        
        session_start();
        $_SESSION['userID'] = $user['id'];
        return true;
    }

    return false;
}

function getUsername($userID){
    global $conn;
    $sql = "SELECT username FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }
    if ($stmt->execute([$userID])) {
        return $stmt->fetch()["username"];
    }
    return false;
}

?>