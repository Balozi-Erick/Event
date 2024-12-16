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


$sql = "SELECT * FROM events ORDER BY event_date DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Events</h1>
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
            <h2>Upcoming Events</h2>
            <?php if ($result->num_rows > 0) : ?>
                <table>
                    <thead>
                        <tr>
                            <th>Event Name</th>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Time</th> 
                            <th>Location</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) : ?>
                            <tr>
                                <td><?php echo $row['event_name']; ?></td>
                                <td><?php echo $row['event_description']; ?></td>
                                <td><?php echo date('F j, Y', strtotime($row['event_date'])); ?></td>
                                <td><?php echo date('g:i A', strtotime($row['event_time'])); ?></td> <!-- Displaying event time -->
                                <td><?php echo $row['location']; ?></td>
                                <td>
                                    <?php if (isset($_SESSION['user_id'])): ?>
                                        <a href="php/book_event.php?event_id=<?php echo $row['event_id']; ?>">Book Now</a>
                                    <?php else: ?>
                                        <a href="php/login.php">Login to Book</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No upcoming events found.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Event Management System. All rights reserved.</p>
    </footer>

    <?php
    
    $conn->close();
    ?>
</body>
</html>
