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

// Check if we are editing an existing event
if (isset($_GET['event_id'])) {  // Use event_id instead of id in the GET parameter
    $event_id = $_GET['event_id'];  // Assuming event_id is the column name in your table

    // Fetch event data from the database
    $sql = "SELECT * FROM events WHERE event_id='$event_id'";  // Make sure this is the correct column
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $event_name = $row['event_name']; // Change events_name to event_name
        $event_date = $row['event_date'];
        $event_time = $row['event_time'];
        $location = $row['location'];
        $event_description = $row['event_description'];
    } else {
        echo "Event not found.";
    }
}

// Handle updating the event
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_event'])) {
    $event_id = $_POST['event_id'];  // Get event_id from the form
    $event_name = htmlspecialchars($_POST['event_name']); // Change events_name to event_name
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $location = htmlspecialchars($_POST['location']);
    $event_description = isset($_POST['event_description']) ? htmlspecialchars($_POST['event_description']) : '';

    $sql = "UPDATE events SET event_name='$event_name', event_date='$event_date', event_time='$event_time', 
            location='$location', event_description='$event_description' WHERE event_id='$event_id'"; // Use event_name here

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
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: white;
            padding: 15px 0;
            text-align: center;
        }

        header nav ul {
            list-style-type: none;
            padding: 0;
        }

        header nav ul li {
            display: inline;
            margin-right: 20px;
        }

        header nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 16px;
        }

        header nav ul li a:hover {
            text-decoration: underline;
        }

        main {
            padding: 40px 20px;
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1, h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        form label {
            font-weight: bold;
            margin-bottom: 8px;
        }

        form input, form textarea, form button {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        form input[type="text"], form input[type="date"], form input[type="time"] {
            width: 100%;
        }

        form textarea {
            width: 100%;
            font-size: 14px;
            resize: vertical;
        }

        form button {
            width: 100%;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border: none;
            padding: 15px;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #0056b3;
        }

        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
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
        <h2>Edit Event Details</h2>
        <form method="POST" action="edit_event.php">
            <?php if (isset($error_message)): ?>
                <div class="message error"><?php echo $error_message; ?></div>
            <?php elseif (isset($success_message)): ?>
                <div class="message success"><?php echo $success_message; ?></div>
            <?php endif; ?>

            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>"> <!-- Hidden field for event_id -->

            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name" value="<?php echo $event_name; ?>" required>

            <label for="event_date">Event Date:</label>
            <input type="date" id="event_date" name="event_date" value="<?php echo $event_date; ?>" required>

            <label for="event_time">Event Time:</label>
            <input type="time" id="event_time" name="event_time" value="<?php echo $event_time; ?>" required>

            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo $location; ?>" required>

            <label for="event_description">Event Description:</label>
            <textarea id="event_description" name="event_description" rows="4"><?php echo $event_description; ?></textarea>

            <button type="submit" name="update_event">Update Event</button>
        </form>
    </section>
</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Event Management System. All rights reserved.</p>
</footer>

</body>
</html>
