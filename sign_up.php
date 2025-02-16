<?php
// Database connection
$servername = "localhost"; // Update if needed
$username = "root";        // Database username
$password = "";            // Database password
$dbname = "college_events_db"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle signup form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match. <a href='signup.html'>Go back</a>");
    }

    // Check if username or email already exists
    $checkSql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        die("Username or email already exists! <a href='signup.html'>Go back</a>");
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert new user into database
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

        if ($stmt->execute()) {
            echo "Signup successful! <a href='login.html'>Go to Login</a>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $checkStmt->close();
}
$conn->close();
?>
