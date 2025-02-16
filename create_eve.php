<?php
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $servername = "localhost";
    $username = "root"; // Update if needed
    $password = "";     // Update if needed
    $dbname = "college_events_db";

    // Database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form data
    $eventName = $_POST['eventName'];
    $eventDescription = $_POST['eventDescription'];
    $venue = $_POST['venue'];
    $mediaPath = null;

    // Handle file upload
    if (isset($_FILES['eventMedia']) && $_FILES['eventMedia']['error'] === 0) {
        $uploadDir = "uploads/";
        $fileName = time() . "_" . basename($_FILES['eventMedia']['name']);
        $uploadFilePath = $uploadDir . $fileName;

        // Create the directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        if (move_uploaded_file($_FILES['eventMedia']['tmp_name'], $uploadFilePath)) {
            $mediaPath = $uploadFilePath; // Save file path to database
        } else {
            echo "<script>alert('Error uploading file.');</script>";
        }
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO events (EventName, Description,Location,Media) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $eventName, $eventDescription, $venue, $mediaPath);

    if ($stmt->execute()) {
        echo "<script>alert('Event successfully created!');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
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
    .form-group textarea {
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
      <div class="form-group">
        <label for="eventMedia">Upload Images or Videos</label>
        <input type="file" id="eventMedia" name="eventMedia" accept="image/*,video/*">
      </div>
      <div class="btn-container">
        <button type="submit" class="btn" id="createButton">Create Event</button>
      </div>
    </form>
  </div>
</body>
</html>
