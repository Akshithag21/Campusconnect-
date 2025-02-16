<?php
// Start session and validate user
session_start();
if (!isset($_SESSION['username'])) {
    die('Unauthorized access.');
}

// Get the club name and action from the POST request
$clubName = $_POST['clubName'] ?? '';
$action = $_POST['action'] ?? '';

if (empty($clubName) || empty($action)) {
    die('Invalid request. Club name and action are required.');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($action); ?> - <?php echo htmlspecialchars($clubName); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .action-form {
            text-align: center;
        }
        .action-form input, .action-form select, .action-form button {
            padding: 10px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .action-form button {
            cursor: pointer;
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo htmlspecialchars($action); ?> for <?php echo htmlspecialchars($clubName); ?></h1>
        </div>
        <?php if ($action === 'Create'): ?>
            <form class="action-form" method="POST" action="create_event.php">
                <input type="hidden" name="clubName" value="<?php echo htmlspecialchars($clubName); ?>">
                <label for="eventName">Event Name:</label>
                <input type="text" name="eventName" id="eventName" required>
                <button type="submit">Create Event</button>
            </form>
        <?php elseif ($action === 'Delete'): ?>
            <form class="action-form" method="POST" action="delete_event.php">
                <input type="hidden" name="clubName" value="<?php echo htmlspecialchars($clubName); ?>">
                <label for="eventName">Select Event:</label>
                <select name="eventName" id="eventName" required>
                    <!-- Example events -->
                    <option value="Event 1">Event 1</option>
                    <option value="Event 2">Event 2</option>
                    <option value="Event 3">Event 3</option>
                </select>
                <button type="submit">Delete Event</button>
            </form>
        <?php elseif ($action === 'View'): ?>
            <div class="action-form">
                <p>Displaying events for <?php echo htmlspecialchars($clubName); ?>:</p>
                <ul>
                    <li>Event 1</li>
                    <li>Event 2</li>
                    <li>Event 3</li>
                </ul>
            </div>
        <?php else: ?>
            <p>Invalid action selected.</p>
        <?php endif; ?>
    </div>
</body>
</html>
