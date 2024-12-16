<?php

session_start();


$servername = "localhost"; 
$username = "root";       
$password = "";            
$dbname = "Boti"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    
    if ($password !== $password_confirm) {
        $error_message = "Passwords do not match!";
    } else {
        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        
        $sql = "INSERT INTO users (username, email, password, user_type, status) 
                VALUES ('$username', '$email', '$hashed_password', 'guest', 'active')";

        if ($conn->query($sql) === TRUE) {
            $success_message = "Registration successful! You can now <a href='php/login.php'>login</a>.";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Register</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../about.php">About Us</a></li>
                <li><a href="../events.php">Events</a></li>
                <li><a href="../contact.php">Contact Us</a></li>
                <li><a href="../php/login.php">Login</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Create a New Account</h2>
            <form method="POST" action="">
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php elseif (isset($success_message)): ?>
                    <p style="color: green;"><?php echo $success_message; ?></p>
                <?php endif; ?>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required placeholder="Choose a username">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required placeholder="Your email address">

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required placeholder="Choose a password">

                <label for="password_confirm">Confirm Password:</label>
                <input type="password" id="password_confirm" name="password_confirm" required placeholder="Confirm your password">

                <button type="submit">Register</button>
            </form>
            <p>Already have an account? <a href="../php/login.php">Login here</a></p>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Event Management System. All rights reserved.</p>
    </footer>
</body>
</html>
