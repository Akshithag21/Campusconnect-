<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "college_events_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$feedback = ""; // Variable to store feedback message

// Handle signup form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $feedback = "<div style='color: red;'>Passwords do not match.</div>";
    } else {
        // Check if email already exists
        $checkSql = "SELECT * FROM users WHERE email = ?";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bind_param("s", $email); // Only check email
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Email already exists
            $feedback = "<div style='color: red;'>Email already exists!</div>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert new user into database
            $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);
            if ($stmt->execute()) {
                $feedback = "<div style='color: green;'>User successfully created! Please Login.</div>";
            } else {
                $feedback = "<div style='color: red;'>Error: " . $stmt->error . "</div>";
            }
            $stmt->close();
        }
        $checkStmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-image: url('mainbackground.jpg');
      background-size: cover;
      background-position: center;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
      position: relative;
    }
    .signup-container {
      background: rgba(255, 255, 255, 0.8);
      backdrop-filter: blur(10px);
      padding: 20px; /* Increased padding */
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 300px; /* Adjusted width */
      height: 400px; /* Increased height */
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px; /* Increased gap between elements */
    }
    .signup-container h1 {
      font-size: 1.2rem;
      color: black;
      margin: 0;
    }
    .signup-container h2 {
      text-align: center;
      margin: 0;
      margin-bottom: 15px; /* Adjusted margin */
      font-size: 1rem;
    }
    form {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 10px; /* Increased gap between form fields */
    }
    input, select, button {
      width: 100%; /* Adjusted width for smaller input boxes */
      padding: 8px; /* Increased padding */
      border-radius: 5px;
      border: 1px solid #ddd;
      font-size: 1rem; /* Increased font size */
    }
    button {
      background-color: #007BFF;
      color: white;
      border: none;
      cursor: pointer;
      font-size: 1rem; /* Increased font size */
      padding: 10px; /* Increased button padding */
    }
    button:hover {
      background-color: #0056b3;
    }
    .back-link {
      text-align: center;
      margin-top: 10px;
    }
    .back-link a {
      text-decoration: none;
      color: #007BFF;
      font-size: 0.9rem; /* Adjusted font size */
    }
    .back-link a:hover {
      text-decoration: underline;
    }
    .logo {
      position: absolute;
      top: 20px;
      right: 20px;
      width: 60px; /* Adjusted logo size */
      height: 80px;
      border-radius: 10px;
      overflow: hidden;
    }
    .logo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
  </style>
</head>
<body>
  <div class="signup-container">
    <h1>Campus Connect</h1>
    <h2>Signup</h2>

    <!-- Feedback Message -->
    <?php echo $feedback; ?>

    <form action="" method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <input type="password" name="confirm_password" placeholder="Confirm Password" required>
      <select name="role" required>
        <option value="" disabled selected>Select Role</option>
        <option value="admin">Admin</option>
        <option value="student">Student</option>
      </select>
      <button type="submit">Signup</button>
    </form>
    <div class="back-link">
      <a href="login.html">Already have an account? Login</a>
    </div>
  </div>
    <!-- Logo Image -->
    <div class="logo">
    <img src="project logo.jpg" alt="Project Logo">
  </div>
</body>
</html>
  