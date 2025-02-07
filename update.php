<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture and sanitize form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];  // No need to use htmlspecialchars for password

    // (Optional) - Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Assuming you have already established the database connection
    $servername = "localhost";
    $username = "root";  // Default username for XAMPP
    $db_password = "";  // Default password for XAMPP is empty
    $dbname = "university db";  // Your database name

    // Create a connection
    $conn = new mysqli($servername, $username, $db_password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update record
    $sql = "UPDATE users SET name='$name', email='$email', password='$password' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div>Record update successfully.</div>";
    } else {
        echo "<div>Error update record: " . $conn->error . "</div>";
    }
    }


?>