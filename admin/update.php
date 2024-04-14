<?php
// Database connection setup (Replace with your database connection details)
$host = "localhost";
$username = "root";
$password = "";
$database = "db";
$conn = mysqli_connect($host, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"];
    $status = $_POST["status"];
    
    // Define the table based on your business logic
    $table = '';  // Add the correct table name here

    // Update the status for the given token
    $sql = "UPDATE $table SET status = '$status' WHERE token = '$token'";

    if (mysqli_query($conn, $sql)) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . mysqli_error($conn);
    }
}

// Close the connection
mysqli_close($conn);
?>
