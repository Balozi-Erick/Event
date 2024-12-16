<?php
// Start session
session_start();

$servername = "localhost";
$username = "root";        
$password = "";            
$dbname = "Boti";          

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;


$sql_category = "SELECT * FROM categories WHERE id = '$category_id'";
$category_result = $conn->query($sql_category);
$category = $category_result->fetch_assoc();


$sql_events = "SELECT * FROM events WHERE category_id = '$category_id' ORDER BY event_date DESC";
$events_result = $conn->query($sql_events);


$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category: <?php echo $category['name']; ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Events in Category: <?php echo $category['name']; ?></h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="events.php">All Events</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <?php if ($events_result->num_rows > 0): ?>
            <section>
                <h2>Upcoming Events</h2>
                <ul>
                    <?php while ($event = $events_result->fetch_assoc()): ?>
                        <li>
                            <h3><?php echo $event['event_name']; ?></h3>
                            <p>Date: <?php echo $event['event_date']; ?></p>
                            <p>Time: <?php echo $event['event_time']; ?></p>
                            <p>Location: <?php echo $event['location']; ?></p>
                            <p><?php echo substr($event['description'], 0, 150); ?>...</p>
                           <a href="event_details.php?id=<?php echo $event['id']; ?>">Read More</a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            </section>
        <?php else: ?>
            <p>No events found in this category.</p>
        <?php endif; ?>
    </main>

   
    <?php include('footer.php'); ?>
</body>
</html>
