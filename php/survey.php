<?php
include('config.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $event_id = $_POST['event_id'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    $sql = "INSERT INTO surveys (user_id, event_id, rating, comments) VALUES ('$user_id', '$event_id', '$rating', '$comments')";
    if ($conn->query($sql) === TRUE) {
        $message = "Thank you for submitting your survey!";
    } else {
        $message = "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Survey</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Event Survey</h1>
        <nav>
            <ul>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="events.php">View Events</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <form method="POST" action="">
            <h2>Share Your Event Experience</h2>

            <?php if (!empty($message)) : ?>
                <p style="color: green;"><?php echo $message; ?></p>
            <?php endif; ?>

            <label for="event_id">Event:</label>
            <select id="event_id" name="event_id" required>
                <?php
                $result = $conn->query("SELECT id, event_name FROM events");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['event_name'] . "</option>";
                }
                ?>
            </select>

            <label for="rating">Rating (1-5):</label>
            <input type="number" id="rating" name="rating" min="1" max="5" required>

            <label for="comments">Comments:</label>
            <textarea id="comments" name="comments" rows="4" placeholder="Share your feedback"></textarea>

            <button type="submit">Submit Survey</button>
        </form>
    </main>
</body>
</html>
