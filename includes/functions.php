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
    if ($stmt) {
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

    $sql = "SELECT id, username, password FROM users WHERE email = ?";
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

function getUsername($userID)
{
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

function isAdmin($userID)
{
    global $conn;
    $sql = "SELECT role FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        return false;
    }
    if ($stmt->execute([$userID])) {
        return $stmt->fetch()["role"] == "admin";
    }
    return false;
}

function getUsers($userID)
{
    global $conn;
    $sql = "SELECT id, username, email, role FROM users WHERE NOT id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "<p>Something wrong</p>";
    }

    if ($stmt->execute([$userID])) {
        if ($stmt->rowCount() > 0) {
            $users = $stmt->fetchAll();
            echo "<table style='width:100%'>";
            echo "<tr>";
            echo "<th>#</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th>";
            echo "</tr>";
            foreach ($users as $user) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($user["id"]) . "</td><td>" . htmlspecialchars($user["username"]) . "</td><td>" . htmlspecialchars($user["email"]) . "</td><td>" . htmlspecialchars($user["role"]) . "</td>";
                echo "<td>";
                echo "<form method='POST' action='edit.php' style='display:inline;'>";
                echo "<button name='id' type='submit' value='".$user["id"]."'>edit</button>";
                echo "</form><form method='POST' action='delete.php' style='display:inline;'>";
                echo "<button name='id' type='submit' value='".$user["id"]."'>delete</button>";
                echo "</form></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else{
            echo "No users";
        }
    } else {
        echo "<p>Something wrong</p>";
    }

}

function deleteUser( $userID )
{
    global $conn;
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<p>Something wrong</p>";
    }
    if ($stmt->execute([$userID])) {
        header("location: index.php");
        exit();
    }
}

function editUser( $userID, $username, $email){
    global $conn;
    $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<p>Something wrong</p>";
    }
    if ($stmt->execute([$username, $email, $userID])) {
        header("location: index.php");
        exit();
    }

}
?>