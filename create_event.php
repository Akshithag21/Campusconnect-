<?php
require 'db_connect.php'; // Include the connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $club = $conn->real_escape_string($_POST['club']); // Get the club name from the form
    $eventName = $conn->real_escape_string($_POST['eventName']);
    $eventDescription = $conn->real_escape_string($_POST['eventDescription']);
    $venue = $conn->real_escape_string($_POST['venue']);

    // Define a whitelist of valid tables to prevent SQL injection
    $allowedTables = [
        'events',
        'rythmic',
        'splashout',
        'sports',
        'rmf',
        'iste',
    ];

    // Check if the selected table is allowed
    if (!in_array($club, $allowedTables)) {
        die("Invalid club selected.");
    }

    // Insert data into the specific club table
    $sql = "INSERT INTO `$club` (event_name, event_description, venue) 
            VALUES ('$eventName', '$eventDescription', '$venue')";

    if ($conn->query($sql) === TRUE) {
        echo "New event created successfully in $club!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create Event</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background: #f5f5f5;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    h1 {
      margin: 20px 0;
      color: #333;
    }

    .form-container {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 90%;
      max-width: 600px;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      font-size: 1rem;
      color: #555;
      margin-bottom: 8px;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
    }

    .form-group input[type="file"] {
      padding: 5px;
    }

    .btn-container {
      display: flex;
      justify-content: flex-end;
    }

    .btn {
      background-color: #4caf50;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1rem;
    }

    .btn:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <h1>Create Event</h1>
  <div class="form-container">
    <form id="createEventForm" action="" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="club">Select Club</label>
        <select id="club" name="club" required>
          <option value="" disabled selected>Choose a club</option>
          <option value="events">Mathletes Club</option>
          <option value="rythmic">Rythmic Thunders</option>
          <option value="splashout">Splashout Club</option>
          <option value="sports">Maidhan Missiles</option>
          <option value="rmf">Rock Me Fab</option>
          <option value="iste">ISTE</option>
        </select>
      </div>
      <div class="form-group">
        <label for="eventName">Event Name</label>
        <input type="text" id="eventName" name="eventName" required>
      </div>
      <div class="form-group">
        <label for="eventDescription">Event Description</label>
        <textarea id="eventDescription" name="eventDescription" rows="4" required></textarea>
      </div>
      <div class="form-group">
        <label for="venue">Venue</label>
        <input type="text" id="venue" name="venue" required>
      </div>
      <div class="btn-container">
        <button type="submit" class="btn" id="createButton">Create Event</button>
      </div>
    </form>
  </div>
</body>
</html>
