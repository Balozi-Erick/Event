<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Boti";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed. Please try again later.");
}

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $customer_name = filter_input(INPUT_POST, 'customer_name', FILTER_SANITIZE_STRING);
    $booking_time = filter_input(INPUT_POST, 'booking_time', FILTER_SANITIZE_STRING);
    $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

    if ($customer_name && $booking_time && $status) {
        // Use prepared statement to insert data
        $stmt = $conn->prepare("INSERT INTO bookings (customer_name, booking_time, status) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $customer_name, $booking_time, $status);

        if ($stmt->execute()) {
            $success = "Your booking has been confirmed!";
        } else {
            $error = "There was an error processing your booking. Please try again.";
        }

        $stmt->close();
    } else {
        $error = "Please fill out all fields correctly.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Event</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Book Event</h1>
        <nav>
            <ul>
                <li><a href="../index.php" aria-label="Go to home page">Home</a></li>
                <li><a href="../about.php" aria-label="Learn about us">About Us</a></li>
                <li><a href="../events.php" aria-label="View events">Events</a></li>
                <li><a href="../php/login.php" aria-label="Log in to your account">Login</a></li>
                <li><a href="../php/register.php" aria-label="Register for an account">Register</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <?php if (isset($success)) : ?>
                <p style="color: green;"><?php echo htmlspecialchars($success); ?></p>
            <?php elseif (isset($error)) : ?>
                <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>

            <h3>Confirm Your Booking</h3>
            <form method="POST" action="">
                <label for="customer_name">Your Name:</label>
                <input type="text" id="customer_name" name="customer_name" required>

                <label for="booking_time">Booking Time:</label>
                <input type="time" id="booking_time" name="booking_time" required>

                <label for="status">Booking Status:</label>
                <select name="status" id="status" required>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="canceled">Canceled</option>
                </select>

                <button type="submit">Confirm Booking</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; <?= date("Y"); ?> Event Management System. All rights reserved.</p>
    </footer>

    <?php
    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
