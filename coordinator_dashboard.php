<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coordinator Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
        }
        .club-box {
            background: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 200px; /* Ensures uniform height */
        }
        .club-box h3 {
            margin: 0;
            color: #333;
        }
        .options {
            display: flex;
            justify-content: space-between;
        }
        .options button {
            padding: 10px;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            width: 30%;
        }
        .create {
            background-color: #28a745;
        }
        .delete {
            background-color: #dc3545;
        }
        .view {
            background-color: #007bff;
        }
        .options button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login.php');
        exit();
    }
    echo "<h1>Welcome Coordinator: " . htmlspecialchars($_SESSION['username']) . "</h1>";
    ?>
    <div class="container">
        <div class="club-box">
            <h3>Rhythmic Thunders</h3>
            <div class="options">
                <button class="create" onclick="navigateTo('Create', 'Rhythmic Thunders')">Create</button>
                <button class="delete" onclick="navigateTo('Delete', 'Rhythmic Thunders')">Delete</button>
                <button class="view" onclick="navigateTo('View', 'Rhythmic Thunders')">View</button>
            </div>
        </div>
        <div class="club-box">
            <h3>GDG</h3>
            <div class="options">
                <button class="create" onclick="navigateTo('Create', 'GDG')">Create</button>
                <button class="delete" onclick="navigateTo('Delete', 'GDG')">Delete</button>
                <button class="view" onclick="navigateTo('View', 'GDG')">View</button>
            </div>
        </div>
        <div class="club-box">
            <h3>Splashout</h3>
            <div class="options">
                <button class="create" onclick="navigateTo('Create', 'Splashout')">Create</button>
                <button class="delete" onclick="navigateTo('Delete', 'Splashout')">Delete</button>
                <button class="view" onclick="navigateTo('View', 'Splashout')">View</button>
            </div>
        </div>
    </div>

    <script>
        function navigateTo(action, clubName) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'operation_page.php'; // Redirect to the operations page

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = action;

            const clubInput = document.createElement('input');
            clubInput.type = 'hidden';
            clubInput.name = 'clubName';
            clubInput.value = clubName;

            form.appendChild(actionInput);
            form.appendChild(clubInput);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>
