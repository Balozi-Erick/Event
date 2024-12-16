<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Management System</title>
    <style>
        /* Reset margins and paddings */
        body, ul {
            margin: 0;
            padding: 0;
        }

        /* Apply background image */
        body {
            background-image: url('ev.jpg'); /* Replace with the correct path to the image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white; /* White text for contrast */
            font-family: Arial, sans-serif;
        }

        /* Style the header */
        header {
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black */
            color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Header title */
        header h1 {
            margin: 0;
            font-size: 1.5rem;
        }

        /* Navigation styles */
        nav ul {
            list-style: none;
            display: flex;
        }

        nav ul li {
            margin: 0 10px;
        }

        nav ul li a {
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 1rem;
        }

        nav ul li a:hover {
            text-decoration: underline;
        }

        /* Main content */
        main {
            padding: 20px;
            text-align: center;
        }

        /* Footer */
        footer {
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent black */
            color: white;
            text-align: center;
            padding: 20px 0; /* Increased padding for more space */
            font-size: 1rem; /* Slightly larger font size for better readability */
            position: relative; /* Position relative to allow for potential child elements */
        }

        footer p {
            margin: 0; /* Remove any default margin */
            font-size: 1rem; /* Adjust font size for better readability */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7); /* Subtle text shadow */
        }

        /* Responsive Design: Footer on small screens */
        @media (max-width: 600px) {
            footer p {
                font-size: 0.9rem; /* Slightly smaller font size for mobile */
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Event Management System</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About Us</a></li>
                <li><a href="events.php">Events</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="php/login.php">Login</a></li>
                <li><a href="php/register.php">Register</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h2>Upcoming Events</h2>
        <p>Discover the latest events happening around you.</p>
    </main>
    <footer>
        <p>&copy; 2024 Event Management System</p>
    </footer>
</body>
</html>
