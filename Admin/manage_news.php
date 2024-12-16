<?php
include 'header.php';
?>

<h2>Manage News</h2>

<!-- Form to add news -->
<form action="process_news.php" method="POST">
    <input type="text" name="news_title" placeholder="News Title" required>
    <textarea name="news_content" placeholder="Content" required></textarea>
    <button type="submit" name="add_news">Add News</button>
</form>

<h3>Existing News</h3>

<?php
// Database connection
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

// Fetch news from database
$sql = "SELECT id, title, content, created_at FROM news ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display news items
    while ($row = $result->fetch_assoc()) {
        echo "<div class='news-item'>";
        echo "<h4>" . htmlspecialchars($row['title']) . "</h4>";
        echo "<p>" . nl2br(htmlspecialchars($row['content'])) . "</p>";
        echo "<small>Published on: " . $row['created_at'] . "</small>";
        echo "<form action='process_news.php' method='POST'>";
        echo "<input type='hidden' name='news_id' value='" . $row['id'] . "'>";
        echo "<button type='submit' name='delete_news' class='delete-btn'>Delete</button>";
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p>No news available.</p>";
}

$conn->close();
?>

<?php include '../footer.php'; ?>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f9;
    }

    header, footer {
        background-color: #333;
        color: white;
        text-align: center;
        padding: 10px 20px;
    }

    main {
        padding: 20px;
    }

    h2, h3 {
        color: #333;
        text-align: center;
    }

    form {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
    }

    form input[type="text"], form textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    form button {
        width: 100%;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    form button:hover {
        background-color: #45a049;
    }

    h4 {
        margin: 0 0 10px;
        color: #444;
    }

    .news-item {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .news-item p {
        color: #555;
        line-height: 1.5;
    }

    .news-item small {
        display: block;
        margin-top: 10px;
        font-size: 0.8em;
        color: #777;
    }

    .news-item form {
        text-align: right;
    }

    .news-item .delete-btn {
        background-color: #f44336;
        color: white;
        border: none;
        padding: 5px 10px;
        border-radius: 4px;
    }

    .news-item .delete-btn:hover {
        background-color: #e53935;
    }
</style>
