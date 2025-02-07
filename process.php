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

    // .............INSERT DATA................
    $stmt = $conn->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>New record created successfully!</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    // Close the statement and connection
    $stmt->close();
    $sql = "SELECT id, name, email FROM user"; // Change this based on your table structure
$result = $conn->query($sql);

// Check if there are results and display them in a table
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' cellspacing='0'>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
            </tr>";
    
    // ...............Output data for each row................
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row['id'] . "</td>
                <td>" . $row['name'] . "</td>
                <td>" . $row['email'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

    $conn->close();
}
?>
