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
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']); // Get the ID from the URL and ensure it's an integer
    
        // Prepare and execute the delete query
        $sql = "DELETE FROM users WHERE id = $id";
    
        if ($conn->query($sql) === TRUE) {
            echo "<div>Record deleted successfully.</div>";
        } else {
            echo "<div>Error deleting record: " . $conn->error . "</div>";
        }
    }
    
    // Fetch all users from the database
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>";
    
        // Display each user in a table row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['name']}</td>
                    <td>{$row['email']}</td>
                    <td>
                        <a href='?id={$row['id']}' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<div>No records found.</div>";
    }
    
    // Close the database connection
    $conn->close();
}
    ?>