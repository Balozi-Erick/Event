<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        /* General body styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        /* Heading styles */
        h2 {
            font-size: 24px;
            color: #333;
            margin: 20px 0;
            text-align: center;
        }

        /* User card styles */
        .user-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin: 15px auto;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }

        /* Card heading */
        .user-card h4 {
            font-size: 18px;
            color: #007bff;
            margin-bottom: 10px;
        }

        /* Card content styles */
        .user-card p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }

        /* Button styles */
        .user-card a,
        .user-card button {
            display: inline-block;
            margin-right: 10px;
            font-size: 14px;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        /* Edit link */
        .user-card a {
            background-color: #007bff;
            color: #fff;
            border: none;
        }

        /* Block button */
        .user-card button[name="block_user"] {
            background-color: red;
            color: white;
            border: none;
        }

        /* Unblock button */
        .user-card button[name="unblock_user"] {
            background-color: green;
            color: white;
            border: none;
        }

        /* Button hover effect */
        .user-card a:hover,
        .user-card button:hover {
            opacity: 0.9;
        }

        /* No users message */
        .no-users {
            text-align: center;
            font-size: 16px;
            color: #888;
            margin-top: 20px;
        }

        /* Form inline display */
        form {
            display: inline;
        }
    </style>
</head>
<body>

<h2>Manage Users</h2>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Boti";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, username, email, user_type, status FROM users ORDER BY username ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='user-card'>";
        echo "<h4>Username: " . htmlspecialchars($row['username']) . "</h4>";
        echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
        echo "<p>User Type: <strong>" . htmlspecialchars($row['user_type']) . "</strong></p>";
        echo "<p>Status: <strong>" . htmlspecialchars($row['status']) . "</strong></p>";
        
        if ($row['user_type'] === 'Registered') {
            echo "<a href='edit_user.php?id=" . $row['id'] . "'>Edit</a>";
        }

        if ($row['status'] === 'Active') {
            echo "<form action='process_users.php' method='POST'>";
            echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
            echo "<button type='submit' name='block_user'>Block</button>";
            echo "</form>";
        } else {
            echo "<form action='process_users.php' method='POST'>";
            echo "<input type='hidden' name='user_id' value='" . $row['id'] . "'>";
            echo "<button type='submit' name='unblock_user'>Unblock</button>";
            echo "</form>";
        }

        echo "</div>";
    }
} else {
    echo "<p class='no-users'>No users found.</p>";
}

$conn->close();
?>

<?php include '../footer.php'; ?>
</body>
</html>
