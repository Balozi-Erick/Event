<?php
// Start session
session_start();

// Check if the user is an admin, if not, redirect to login page
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] != 'admin') {
    header('Location: ../php/login.php'); // Use a clear redirection target
    exit();
}

// Database connection (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Boti";

// Create connection using mysqli
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// CSRF token generation and validation
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function validateCsrfToken($token) {
    return hash_equals($_SESSION['csrf_token'], $token);
}

// Handle adding a new category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_category'])) {
    if (validateCsrfToken($_POST['csrf_token'])) {
        $category_name = htmlspecialchars(trim($_POST['category_name']));
        if (!empty($category_name)) {
            $stmt = $conn->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->bind_param("s", $category_name);

            if ($stmt->execute()) {
                $success_message = "Category added successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_message = "Category name cannot be empty!";
        }
    } else {
        $error_message = "Invalid CSRF token!";
    }
}

// Handle updating an existing category
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_category'])) {
    if (validateCsrfToken($_POST['csrf_token'])) {
        $category_id = intval($_POST['category_id']);
        $category_name = htmlspecialchars(trim($_POST['category_name']));
        if (!empty($category_name)) {
            $stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
            $stmt->bind_param("si", $category_name, $category_id);

            if ($stmt->execute()) {
                $success_message = "Category updated successfully!";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $error_message = "Category name cannot be empty!";
        }
    } else {
        $error_message = "Invalid CSRF token!";
    }
}

// Handle deleting a category
if (isset($_GET['delete_category'])) {
    $category_id = intval($_GET['delete_category']);
    if ($category_id > 0) {
        $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
        $stmt->bind_param("i", $category_id);

        if ($stmt->execute()) {
            $success_message = "Category deleted successfully!";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch all categories from the database
$stmt = $conn->prepare("SELECT * FROM categories ORDER BY name ASC");
$stmt->execute();
$result = $stmt->get_result();
$categories = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Manage Categories</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../Admin/manage_categories.php">Manage Categories</a></li>
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section>
            <h2>Add New Category</h2>
            <form method="POST" action="">
                <!-- Display messages -->
                <?php if (isset($error_message)): ?>
                    <p style="color: red;"><?php echo $error_message; ?></p>
                <?php elseif (isset($success_message)): ?>
                    <p style="color: green;"><?php echo $success_message; ?></p>
                <?php endif; ?>

                <!-- CSRF token -->
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" required>

                <button type="submit" name="add_category">Add Category</button>
            </form>
        </section>

        <section>
            <h2>Existing Categories</h2>
            <?php if (!empty($categories)): ?>
                <table>
                    <tr>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <form method="POST" action="">
                                <!-- Inline editing form -->
                                <td>
                                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                    <input type="hidden" name="category_id" value="<?php echo $category['id']; ?>">
                                    <input type="text" name="category_name" value="<?php echo htmlspecialchars($category['name']); ?>" required>
                                </td>
                                <td>
                                    <button type="submit" name="update_category">Save</button>
                                    <a href="?delete_category=<?php echo $category['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this category?')">Delete</a>
                                </td>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <p>No categories found.</p>
            <?php endif; ?>
        </section>
    </main>

    <!-- Include the footer -->
    <?php include('footer.php'); ?>
</body>
</html>
