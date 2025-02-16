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

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['login']; // 'admin' or 'student'

    // Check if user exists and has the correct role
    $sql = "SELECT * FROM users WHERE email = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Redirect to the appropriate dashboard
            if ($role === 'student') {
                header("Location: student_dashboard.html");
            } elseif ($role === 'admin') {
                header("Location: coordinator_dashboard.html");
            }
            exit();
        } else {
            echo "Invalid password. <a href='login.html'>Try again</a>";
        }
    } else {
        echo "User not found or role mismatch. <a href='login.html'>Try again</a>";
    }

    $stmt->close();
}
$conn->close();
?>
