<?php
// Database connection (replace with your actual credentials)
$servername = "localhost"; // or your database host
$username = "root";        // your database username
$password = "";            // your database password
$dbname = "Boti";  // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch sponsors from the database
$sql = "SELECT * FROM sponsors";
$result = $conn->query($sql);

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sponsors</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Sponsors</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Our Sponsors</h2>
            <?php if ($result->num_rows > 0): ?>
                <div class="sponsor-list">
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <div class="sponsor-item">
                            <?php if ($row['logo_url']): ?>
                                <img src="<?php echo $row['logo_url']; ?>" alt="<?php echo $row['name']; ?> Logo" class="sponsor-logo">
                            <?php endif; ?>
                            <h3><?php echo $row['name']; ?></h3>
                            <p><?php echo $row['description']; ?></p>
                            <?php if ($row['website_url']): ?>
                                <a href="<?php echo $row['website_url']; ?>" target="_blank">Visit Website</a>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p>No sponsors found.</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Event Management System. All rights reserved.</p>
    </footer>
</body>
</html>
