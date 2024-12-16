<?php include 'header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings</title>
    <style>
        /* General page styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        h2 {
            font-size: 24px;
            text-align: center;
            color: #333;
            margin: 20px 0;
        }

        /* Booking card styling */
        .booking-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            margin: 15px auto;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }

        /* Booking card heading */
        .booking-card h4 {
            font-size: 18px;
            color: #007bff;
            margin-bottom: 10px;
        }

        /* Booking card details */
        .booking-card p {
            font-size: 14px;
            color: #555;
            margin: 5px 0;
        }

        /* Buttons */
        .booking-card button {
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            margin-right: 5px;
            transition: background-color 0.3s ease;
        }

        /* Confirm button */
        .booking-card button[name="confirm_booking"] {
            background-color: green;
            color: white;
        }

        /* Cancel button */
        .booking-card button[name="cancel_booking"] {
            background-color: red;
            color: white;
        }

        /* Button hover effect */
        .booking-card button:hover {
            opacity: 0.9;
        }

        /* No bookings message */
        .no-bookings {
            text-align: center;
            font-size: 16px;
            color: #888;
            margin-top: 20px;
        }

        /* Form inline display */
        form {
            display: inline;
        }
    </style>
</head>
<body>

<h2>Manage Bookings</h2>

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

// Fetch bookings from database
$sql = "SELECT id, customer_name, booking_date, booking_time, status FROM bookings ORDER BY booking_date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Display bookings
    while ($row = $result->fetch_assoc()) {
        echo "<div class='booking-card'>";
        echo "<h4>Customer: " . htmlspecialchars($row['customer_name']) . "</h4>";
        echo "<p>Date: " . $row['booking_date'] . " at " . $row['booking_time'] . "</p>";
        echo "<p>Status: <strong>" . htmlspecialchars($row['status']) . "</strong></p>";

        // Confirm and Cancel options
        echo "<form action='process_bookings.php' method='POST'>";
        echo "<input type='hidden' name='booking_id' value='" . $row['id'] . "'>";
        if ($row['status'] !== 'Confirmed') {
            echo "<button type='submit' name='confirm_booking'>Confirm</button>";
        }
        if ($row['status'] !== 'Cancelled') {
            echo "<button type='submit' name='cancel_booking'>Cancel</button>";
        }
        echo "</form>";
        echo "</div>";
    }
} else {
    echo "<p class='no-bookings'>No bookings available.</p>";
}

$conn->close();
?>

<?php include '../footer.php'; ?>
</body>
</html>
