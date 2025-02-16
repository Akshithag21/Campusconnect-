<?php
session_start(); // Start session for user login tracking

// Database connection
$servername = "localhost";
$username = "root"; 
$password = ""; 
$database = "college_events_db";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Sanitize user input
    $email = htmlspecialchars($email);

    // Query to check credentials
    $stmt = $conn->prepare("SELECT id, username, role, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] === 'student') {
                header("Location: view.php?club=rythmic-thunders"); // Default club for student
                exit();
            } elseif ($row['role'] === 'club coordinator') {
                header("Location: view.php?club=gdg-club"); // Default club for coordinators
                exit();
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }
    $stmt->close();
}

$conn->close();
?>