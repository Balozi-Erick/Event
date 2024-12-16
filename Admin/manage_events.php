<?php include 'header.php'; ?>

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

// Handle adding a new event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $event_name = htmlspecialchars($_POST['event_name']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = htmlspecialchars($_POST['location']);
    $event_description = isset($_POST['event_description']) ? htmlspecialchars($_POST['event_description']) : '';

    $sql = "INSERT INTO events (event_name, event_date, event_time, location, event_description) 
            VALUES ('$event_name', '$event_date', '$event_time', '$location', '$event_description')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Event added successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Handle deleting an event
if (isset($_GET['delete_event'])) {
    $event_id = $_GET['delete_event'];
    $sql = "DELETE FROM events WHERE event_id='$event_id'";

    if ($conn->query($sql) === TRUE) {
        $success_message = "Event deleted successfully!";
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Fetch all events
$sql = "SELECT * FROM events ORDER BY event_date DESC";
$result = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Events</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }
        header {
            background: #333;
            color: white;
            padding: 1em;
            text-align: center;
        }
        main {
            padding: 2em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        a {
            text-decoration: none;
            color: blue;
        }
        a:hover {
            text-decoration: underline;
        }
        a.delete {
            color: red;
        }
        form {
            background: white;
            padding: 2em;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin: 1em 0 0.5em;
        }
        input, textarea, button {
            width: 100%;
            padding: 0.7em;
            margin-bottom: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background: #333;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background: #555;
        }
    </style>
</head>
<body>

<header>
    <h1>Manage Events</h1>
</header>

<main>
    <section>
        <h2>Add New Event</h2>
        <form method="POST" action="">
            <?php if (isset($error_message)): ?>
                <p style="color: red;"> <?php echo $error_message; ?> </p>
            <?php elseif (isset($success_message)): ?>
                <p style="color: green;"> <?php echo $success_message; ?> </p>
            <?php endif; ?>

            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" required>

            <label for="event_date">Event Date:</label>
            <input type="date" id="event_date" name="event_date" required>

            <label for="event_time">Event Time:</label>
            <input type="time" id="event_time" name="event_time" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required>

            <label for="event_description">Event Description:</label>
            <textarea id="event_description" name="event_description" rows="4" required></textarea>

            <button type="submit" name="add_event">Add Event</button>
        </form>
    </section>

    <section>
        <h2>Existing Events</h2>
        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>Event Name</th>
                    <th>Event Date</th>
                    <th>Event Time</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['event_name']; ?></td>
                        <td><?php echo $row['event_date']; ?></td>
                        <td><?php echo $row['event_time']; ?></td>
                        <td><?php echo $row['location']; ?></td>
                        <td>
                            <a href="update_event.php?id=<?php echo $row['event_id']; ?>">Edit</a> |
                            <a href="?delete_event=<?php echo $row['event_id']; ?>" class="delete" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Event Management System. All rights reserved.</p>
</footer>

</body>
</html>
