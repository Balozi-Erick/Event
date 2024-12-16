<?php
// Include header if necessary
include 'header.php';

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Boti";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch event details if the 'id' parameter is set
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Correct the SQL query by using 'event_id'
    $sql = "SELECT * FROM events WHERE event_id='$event_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the event data
        $event = $result->fetch_assoc();
    } else {
        // Redirect back if no event is found
        header("Location: manage_events.php");
        exit();
    }
}

// Handle updating an existing event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_event'])) {
    $event_name = htmlspecialchars($_POST['event_name']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = htmlspecialchars($_POST['location']);
    $event_description = htmlspecialchars($_POST['event_description']);

    // Correct the update query
    $sql = "UPDATE events SET event_name='$event_name', event_date='$event_date', event_time='$event_time', 
            location='$location', event_description='$event_description' WHERE event_id='$event_id'";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Event updated successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Internal CSS styling */
    </style>
</head>
<body>

<header>
    <h1>Edit Event</h1>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="manage_events.php">Manage Events</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<main>
    <section>
        <h2>Edit Event</h2>
        <form method="POST" action="">
            <?php if (isset($error_message)): ?>
                <p style="color: red;"> <?php echo $error_message; ?> </p>
            <?php elseif (isset($success_message)): ?>
                <p style="color: green;"> <?php echo $success_message; ?> </p>
            <?php endif; ?>

            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" value="<?php echo $event['event_name']; ?>" required>

            <label for="event_date">Event Date:</label>
            <input type="date" id="event_date" name="event_date" value="<?php echo $event['event_date']; ?>" required>

            <label for="event_time">Event Time:</label>
            <input type="time" id="event_time" name="event_time" value="<?php echo $event['event_time']; ?>" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo $event['location']; ?>" required>

            <label for="event_description">Event Description:</label>
            <textarea id="event_description" name="event_description" rows="4" required><?php echo $event['event_description']; ?></textarea>

            <button type="submit" name="update_event">Update Event</button>
        </form>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Event Management System. All rights reserved.</p>
</footer>

</body>
</html>
