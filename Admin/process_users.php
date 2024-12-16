<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Boti";

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = intval($_POST['user_id']);

    if (isset($_POST['block_user'])) {
        $sql = "UPDATE users SET status='Blocked' WHERE id=$user_id";
    } elseif (isset($_POST['unblock_user'])) {
        $sql = "UPDATE users SET status='Active' WHERE id=$user_id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_users.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
