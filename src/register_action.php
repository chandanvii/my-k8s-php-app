<?php
$servername = "mysql";
$username = "root";
$password = "root";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST data is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form inputs
    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $password = isset($_POST['password']) ? $_POST['password'] : null;

    // Validate required fields
    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required.");
    }

    // Sanitize inputs to prevent SQL injection
    $username = $conn->real_escape_string($username);
    $email = $conn->real_escape_string($email);
    $password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security

    // Prepare and bind
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare failed: (" . $conn->errno . ") " . $conn->error);
    }

    $stmt->bind_param("sss", $username, $email, $password);

    // Execute statement
    if (!$stmt->execute()) {
        die("Execution failed: (" . $stmt->errno . ") " . $stmt->error);
    }

    echo "Registration successful!";
    $stmt->close();
} else {
    die("Invalid request method.");
}

$conn->close();
?>
