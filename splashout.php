<?php
require 'db_connect.php'; // Include the connection file
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    // Delete the event with the given ID
    $deleteId = $conn->real_escape_string($_POST['delete_id']);
    $deleteSql = "DELETE FROM splashout WHERE id = $deleteId";

    if ($conn->query($deleteSql) === TRUE) {
        echo "<script>alert('Event deleted successfully!');</script>";
    } else {
        echo "<script>alert('Error deleting event: " . $conn->error . "');</script>";
    }
}

$sql = "SELECT * FROM splashout ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Splash Out</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Marquee */
        .marquee {
            background-color: #fbaed2;
            color: black;
            padding: 10px 0;
            overflow: hidden;
            white-space: nowrap;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            font-size: 28px;
            font-weight: bold;
        }

        .marquee span {
            display: inline-block;
            animation: scroll-right 10s linear infinite;
        }

        .marquee:hover span {
            animation-play-state: paused; /* Pause on hover */
        }

        @keyframes scroll-right {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }

        /* Container */
        .container {
            padding: 20px;
            max-width: 600px;
            margin: 80px auto 20px;
        }

        /* Event Box */
        .box {
            background-color: #fff;
            border: 2px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .box h2 {
            margin: 0;
            font-size: 24px;
            text-align: center;
        }

        .box p {
            margin: 10px 0;
        }

        .box .status {
            color: green;
            font-weight: bold;
            position: absolute;
            bottom: 10px;
            left: 15px;
        }

        .box .view {
            position: absolute;
            bottom: 10px;
            right: 15px;
        }

        .box .view button {
            background-color: #aee9fb;
            color: black;
            border: none;
            border-radius: 5px;
            padding: 10px 30px;
            cursor: pointer;
            font-size: 16px;
        }

        .box .view button:hover {
            opacity: 0.8;
        }

        .relative {
            position: relative;
            height: 150px;
        }
    </style>
</head>
<body>

<div class="marquee">
    <span>Splash Out</span>
</div>

<div class="container">
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='box'>";
            echo "<h2>" . htmlspecialchars($row['event_name']) . "</h2>";
            echo "<p>" . htmlspecialchars($row['event_description']) . "</p>";
            echo "<p><strong>Venue:</strong> " . htmlspecialchars($row['venue']) . "</p>";
            echo "<form class='delete-form' method='POST' action=''>";
            echo "<input type='hidden' name='delete_id' value='" . htmlspecialchars($row['id']) . "'>";
            echo "<button type='submit'>Delete</button>";
            echo "</form>";
            echo "</div>";
        }
    } else {
        echo "<p>No events found.</p>";
    }

    $conn->close();
    ?>
    
    <div class="box relative">
        <h2>Shri Krishna Janmastami</h2>
        <div class="status">Status: Past</div>
        <div class="view">
            <button onclick="location.href='ks_description.html'">View</button>
        </div>
    </div>
    <div class="box relative">
        <h2>Film & Fun Feista</h2>
        <div class="status">Status: Past</div>
        <div class="view">
            <button onclick="location.href='ff_description.html'">View</button>
        </div>
    </div>
</div>

</body>
</html>