<?php

require_once("database.php");
function displayErr($msg)
{
    echo "<p>" . htmlspecialchars($msg) . "</p>";
}

function buildUsersTable($userID)
{
    $db = new Database();

    $users = $db->getAllUsers($userID);

    if ($users) {
        echo "<table style='width:100%'>";
        echo "<tr>";
        echo "<th>#</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th>";
        echo "</tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($user["id"]) . "</td><td>" . htmlspecialchars($user["username"]) . "</td><td>" . htmlspecialchars($user["email"]) . "</td><td>" . htmlspecialchars($user["role"]) . "</td>";
            echo "<td>";
            echo "<form method='POST' action='edit.php' style='display:inline;'>";
            echo "<button name='id' type='submit' value='" . $user["id"] . "'>edit</button>";
            echo "</form><form method='POST' action='delete.php' style='display:inline;'>";
            echo "<button name='id' type='submit' value='" . $user["id"] . "'>delete</button>";
            echo "</form></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "No users";
    }

}

?>