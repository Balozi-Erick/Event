<?php
// Start session
session_start();

// Check if the user is an admin, if not, redirect to login page
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Database connection (replace with your actual credentials)
$servername = "localhost"; // your database host
$username = "root";        // your database username
$password = "";            // your database password
$dbname = "Boti"; // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process Add Event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $event_name = htmlspecialchars($_POST['event_name']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']);
    $status = $_POST['status'];

    // Insert the new event into the database
    $sql = "INSERT INTO events (event_name, event_date, event_time, location, description, status) 
            VALUES ('$event_name', '$event_date', '$event_time', '$location', '$description', '$status')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Event added successfully!";
        header('Location: manage_events.php');
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
        header('Location: manage_events.php');
        exit();
    }
}

// Process Update Event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_event'])) {
    $event_id = $_POST['event_id'];
    $event_name = htmlspecialchars($_POST['event_name']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = htmlspecialchars($_POST['location']);
    $description = htmlspecialchars($_POST['description']);
    $status = $_POST['status'];

    // Update the event in the database
    $sql = "UPDATE events SET event_name='$event_name', event_date='$event_date', event_time='$event_time', 
            location='$location', description='$description', status='$status' WHERE id='$event_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Event updated successfully!";
        header('Location: manage_events.php');
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
        header('Location: manage_events.php');
        exit();
    }
}

// Process Delete Event
if (isset($_GET['delete_event'])) {
    $event_id = $_GET['delete_event'];

    // Delete the event from the database
    $sql = "DELETE FROM events WHERE id='$event_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Event deleted successfully!";
        header('Location: manage_events.php');
        exit();
    } else {
        $_SESSION['error'] = "Error: " . $conn->error;
        header('Location: manage_events.php');
        exit();
    }
}

// Close the connection
$conn->close();
?>
