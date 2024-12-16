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
    // Get form inputs and sanitize them
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Prepare SQL to insert the contact form data into the database
    $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";

    // Prepare statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters and execute
        $stmt->bind_param("sss", $name, $email, $message);

        // Execute the statement and check if it was successful
        if ($stmt->execute()) {
            $_SESSION['success'] = "Thank you, $name! Your message has been sent.";
        } else {
            $_SESSION['error'] = "There was an issue sending your message. Please try again later.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Error preparing the query. Please try again later.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Contact Us</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="php/login.php">Login</a></li>
                <li><a href="php/register.php">Register</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>We’d love to hear from you!</h2>
            <p>Feel free to reach out to us with any questions, suggestions, or concerns.</p>
        </section>

        <form method="POST" action="">
            <?php if (isset($_SESSION['success'])): ?>
                <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
            <?php elseif (isset($_SESSION['error'])): ?>
                <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Your Name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Your Email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" rows="5" placeholder="Write your message here..." required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Event Management System. All rights reserved.</p>
    </footer>
</body>
</html>
