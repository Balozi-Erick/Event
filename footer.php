<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Footer</title>
    <style>
        footer {
            background-color: #282c34; /* Dark gray background */
            color: #ffffff; /* White text for contrast */
            text-align: center; /* Centered content */
            padding: 15px 0; /* Padding for spacing */
            margin-top: 20px; /* Adds some space above the footer */
            font-size: 14px; /* Adjust font size */
            letter-spacing: 0.5px; /* Slightly spaced letters for readability */
            box-shadow: 0 -1px 5px rgba(0, 0, 0, 0.2); /* Subtle shadow on top */
        }

        footer p {
            margin: 0; /* Removes default margins */
            font-family: Arial, sans-serif; /* Clean font */
        }

        /* Optional: Add styling for links inside the footer */
        footer a {
            color: #4caf50; /* Green for links */
            text-decoration: none; /* Removes underline */
            font-weight: bold; /* Makes links stand out */
        }

        footer a:hover {
            text-decoration: underline; /* Adds underline on hover */
        }
    </style>
</head>
<body>
    <!-- Footer content -->
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Event Management System. All rights reserved.</p>
    </footer>
</body>
</html>
