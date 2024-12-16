<?php
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

// Check if the delete_event parameter is set in the URL
if (isset($_GET['delete_event'])) {
    $event_id = $_GET['delete_event'];

    // Sanitize the event_id to prevent SQL injection
    $event_id = intval($event_id);

    // Prepare and execute the delete query
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);

    if ($stmt->execute()) {
        // Redirect to the manage events page with a success message
        header("Location: manage_events.php?success=1");
        exit();
    } else {
        // Redirect to the manage events page with an error message
        header("Location: manage_events.php?error=1");
        exit();
    }
} else {
    // If no event_id is provided in the URL, redirect to the manage events page
    header("Location: manage_events.php");
    exit();
}

// Close the connection
$conn->close();
?>
