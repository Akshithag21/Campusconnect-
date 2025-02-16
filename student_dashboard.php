<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club Selection</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background: black;
            color: #ffffff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: start;
            min-height: 100vh;
        }

        h1 {
            font-size: 26px;
            margin-top: 20px;
            text-align: center;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }

        /* Container for Clubs */
        .container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            width: 90%;
            max-width: 1000px;
            margin-top: 30px;
        }

        /* Club Card */
        .club-box {
            background: #ffffff;
            color: #333333;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .club-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        /* Club Title */
        .club-title {
            background: #f4f4f4;
            padding: 15px 0;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            border-bottom: 2px solid #007BFF;
        }

        /* Button */
        .view-btn {
            display: block;
            background: #007BFF;
            color: #ffffff;
            text-decoration: none;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .view-btn:hover {
            background: #0056b3;
        }
        
    </style>
   
</head>
<body>
    <!-- Header Section -->
    <h1 id="yash" style="color:black;" >
    <?php
        session_start();
        echo "<h1>Welcome Student: " . htmlspecialchars($_SESSION['username']) . "</h1>";
    ?>
    </h1>
    
    <!-- Club Selection Container -->
    <div class="container">
        <!-- Club 1 -->
        <div class="club-box">
            <div class="club-title">Rhythmic Thunders</div>
            <a href="view.php?club=rythmic-thunders" class="view-btn">View Details</a>
        </div>

        <!-- Club 2 -->
        <div class="club-box">
            <div class="club-title">GDG Club</div>
            <a href="view.php?club=gdg-club" class="view-btn">View Details</a>
        </div>

        <!-- Club 3 -->
        <div class="club-box">
            <div class="club-title">Splash Out</div>
            <a href="view.php?club=splash-out" class="view-btn">View Details</a>
        </div>
    </div>
</body>
</html>