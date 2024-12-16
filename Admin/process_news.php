<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Boti";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add news
if (isset($_POST['add_news'])) {
    $newsTitle = $_POST['news_title'];
    $newsContent = $_POST['news_content'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO news (title, content) VALUES (?, ?)");
    $stmt->bind_param("ss", $newsTitle, $newsContent);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_news.php"); // Redirect to the manage news page after adding
    exit;
}

// Delete news
if (isset($_POST['delete_news'])) {
    $newsId = $_POST['news_id'];

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM news WHERE id = ?");
    $stmt->bind_param("i", $newsId);
    $stmt->execute();
    $stmt->close();

    header("Location: manage_news.php"); // Redirect to the manage news page after deletion
    exit;
}

$conn->close();
?>
