<?php

$servername = "localhost"; 
$username = "root";        
$password = "";            
$dbname = "Boti"; 
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action']) && $_POST['action'] == 'Add') {
        $name = htmlspecialchars($_POST['name']);
        $logo_url = htmlspecialchars($_POST['logo_url']);
        $description = htmlspecialchars($_POST['description']);
        $website_url = htmlspecialchars($_POST['website_url']);

        $sql = "INSERT INTO sponsors (name, logo_url, description, website_url) 
                VALUES ('$name', '$logo_url', '$description', '$website_url')";
        if ($conn->query($sql) === TRUE) {
            $success_message = "New sponsor added successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    } elseif (isset($_POST['action']) && $_POST['action'] == 'Edit') {
        $id = $_POST['id'];
        $name = htmlspecialchars($_POST['name']);
        $logo_url = htmlspecialchars($_POST['logo_url']);
        $description = htmlspecialchars($_POST['description']);
        $website_url = htmlspecialchars($_POST['website_url']);

        $sql = "UPDATE sponsors 
                SET name='$name', logo_url='$logo_url', description='$description', website_url='$website_url' 
                WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            $success_message = "Sponsor updated successfully!";
        } else {
            $error_message = "Error: " . $conn->error;
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM sponsors WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        $success_message = "Sponsor deleted successfully!";
    } else {
        $error_message = "Error deleting sponsor: " . $conn->error;
    }
}

$sql = "SELECT * FROM sponsors";
$sponsors = $conn->query($sql);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Sponsors</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        nav {
            width: 200px;
            background-color: #333;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
        }

        nav ul li {
            text-align: center;
            margin-bottom: 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
        }

        nav ul li a:hover {
            background-color: #575757;
        }

        main {
            margin-left: 220px;
            padding: 20px;
            width: calc(100% - 220px);
        }

        header {
            background-color: #444;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        footer {
            background-color: #444;
            color: white;
            text-align: center;
            padding: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        form input[type="text"],
        form input[type="url"],
        form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        form textarea {
            height: 100px;
            resize: none;
        }

        form button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        form button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f4f4f4;
        }

        table img {
            border-radius: 4px;
        }

        table a {
            color: #0066cc;
            text-decoration: none;
        }

        table a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>Manage Sponsors</h1>
    </header>

    <nav>
        <ul>
            <li><a href="admin_dashboard.php">Home</a></li>
            <li><a href="../about.php">About Us</a></li>
            <li><a href="../events.php">Events</a></li>
            <li><a href="../contact.php">Contact Us</a></li>
        </ul>
    </nav>

    <main>
        <section>
            <h2>Add New Sponsor</h2>
            <form method="POST" action="">
                <label for="name">Sponsor Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="logo_url">Logo URL:</label>
                <input type="text" id="logo_url" name="logo_url">

                <label for="description">Description:</label>
                <textarea id="description" name="description" required></textarea>

                <label for="website_url">Website URL:</label>
                <input type="url" id="website_url" name="website_url">

                <input type="hidden" name="action" value="Add">
                <button type="submit">Add Sponsor</button>
            </form>
        </section>

        <section>
            <h2>Existing Sponsors</h2>
            <?php if (isset($success_message)): ?>
                <p style="color: green;"><?php echo $success_message; ?></p>
            <?php elseif (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>

            <?php if ($sponsors->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Logo</th>
                            <th>Description</th>
                            <th>Website</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $sponsors->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><img src="<?php echo $row['logo_url']; ?>" alt="Logo" class="sponsor-logo" width="50"></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><a href="<?php echo $row['website_url']; ?>" target="_blank">Visit</a></td>
                                <td>
                                    <a href="manage_sponsors.php?edit=<?php echo $row['id']; ?>">Edit</a> | 
                                    <a href="manage_sponsors.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this sponsor?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
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
