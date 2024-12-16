<?php

session_start();


$adminUsers = [
    'A101' => 'Admin101',
    'A202' => 'Admin202',
    'A303' => 'Admin303',
    'A404' => 'Admin404'
];


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Boti";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $admin_username = htmlspecialchars($_POST['username']);
    $admin_password = $_POST['password'];

    
    if (array_key_exists($admin_username, $adminUsers) && $adminUsers[$admin_username] == $admin_password) {
        
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin_username;

        
        header("Location: admin_dashboard.php");
        exit();
    } else {
        
        $error_message = "Invalid Admin credentials.";
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Admin Login</h1>
    </header>

    <main>
        <section>
            <h2>Please login to access the Admin Dashboard</h2>

            <form method="POST" action="">
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php endif; ?>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Event Management System. All rights reserved.</p>
    </footer>
</body>
</html>
