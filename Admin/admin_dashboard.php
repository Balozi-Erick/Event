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

$totalCategories = $totalSponsors = $totalEvents = $totalUsers = $totalBookings = $confirmedBookings = $cancelledBookings = 0;

$queries = [
    'totalCategories' => "SELECT COUNT(*) FROM categories",
    'totalSponsors' => "SELECT COUNT(*) FROM sponsors",
    'totalEvents' => "SELECT COUNT(*) FROM events",
    'totalUsers' => "SELECT COUNT(*) FROM users",
    'totalBookings' => "SELECT COUNT(*) FROM bookings",
    'confirmedBookings' => "SELECT COUNT(*) FROM bookings WHERE status = 'confirmed'",
    'cancelledBookings' => "SELECT COUNT(*) FROM bookings WHERE status = 'cancelled'",
];

foreach ($queries as $key => $query) {
    $result = $conn->query($query);
    if ($result) {
        $$key = $result->fetch_row()[0];
    } else {
        $$key = 0;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h2 {
            background-color: #333;
            color: white;
            padding: 20px;
            margin: 0;
        }
        p {
            font-size: 18px;
            color: #555;
            background-color: #e8f4f8;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            border-left: 5px solid #007bff;
            font-style: italic;
            font-weight: bold;
            text-align: center;
            text-transform: capitalize;
            font-size: 50px;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding: 20px;
        }
        .stat-item {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-item strong {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }
        .stat-item div {
            font-size: 24px;
            color: #007bff;
        }
        .sidebar {
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            color: white;
            padding-top: 20px;
            height: 100vh;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #575757;
        }
        .main-content {
            margin-left: 220px;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h3 style="color: white; text-align: center; padding-bottom: 20px;">Admin Dashboard</h3>
    <a href="manage_categories.php">Manage Categories</a>
    <a href="manage_sponsors.php">Manage Sponsors</a>
    <a href="manage_events.php">Manage Events</a>
    <a href="manage_users.php">Manage Users</a>
    <a href="manage_bookings.php">Manage Bookings</a>
    <a href="manage_news.php">Manage News</a>
    <a href="profile.php">Profile</a>
    <a href="logout.php">Logout</a>
</div>

<div class="main-content">
    <h2>Dashboard</h2>
    <p>Welcome, Here is an overview of the system statistics:</p>

    <div class="stats">
        <div class="stat-item">
            <strong>Total Categories:</strong>
            <div><?php echo number_format($totalCategories); ?></div>
        </div>
        <div class="stat-item">
            <strong>Total Sponsors:</strong>
            <div><?php echo number_format($totalSponsors); ?></div>
        </div>
        <div class="stat-item">
            <strong>Total Events:</strong>
            <div><?php echo number_format($totalEvents); ?></div>
        </div>
        <div class="stat-item">
            <strong>Total Registered Users:</strong>
            <div><?php echo number_format($totalUsers); ?></div>
        </div>
        <div class="stat-item">
            <strong>Total Bookings:</strong>
            <div><?php echo number_format($totalBookings); ?></div>
        </div>
        <div class="stat-item">
            <strong>Total Confirmed Bookings:</strong>
            <div><?php echo number_format($confirmedBookings); ?></div>
        </div>
        <div class="stat-item">
            <strong>Total Cancelled Bookings:</strong>
            <div><?php echo number_format($cancelledBookings); ?></div>
        </div>
    </div>
</div>

</body>
</html>

<?php
$conn->close();
?>
