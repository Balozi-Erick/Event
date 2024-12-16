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

if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);
    $sql = "SELECT username, email FROM users WHERE id=$user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("User not found.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null;

    if ($password) {
        $sql = "UPDATE users SET username='$username', email='$email', password='$password' WHERE id=$user_id";
    } else {
        $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$user_id";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_users.php");
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<h2>Edit User</h2>
<form action="" method="POST">
    <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    <input type="password" name="password" placeholder="New Password (optional)">
    <button type="submit">Update</button>
</form>
