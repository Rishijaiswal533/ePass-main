<?php
// Database connection setup (Replace with your database connection details)
$host = "localhost";
$username = "root";
$password = "";
$database = "db";
$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $status = $_POST['status'];

    // Initialize the table name
    $table = '';

    // Determine the table based on whether the token is present in the table
    // Replace these conditions with the actual logic to check if the token is in a specific table
    if (tokenExistsInTable($conn, 'emg', $token)) {
        $table = 'emg';
    } elseif (tokenExistsInTable($conn, 'y1', $token)) {
        $table = 'y1';
    } elseif (tokenExistsInTable($conn, 'y2', $token)) {
        $table = 'y2';
    } elseif (tokenExistsInTable($conn, 'n2', $token)) {
        $table = 'n2';
    }

    if ($table) {
        // Update the status in the selected table
        $sql = "UPDATE $table SET status = '$status' WHERE token = '$token'";
        if (mysqli_query($conn, $sql)) {
            // Status update successful, redirect to view.php
            header("Location: view.php?token=$token");
            exit; // Stop further execution
        } else {
            echo "error"; // Status update failed
        }
    } else {
        echo "error"; // Could not determine the appropriate table
    }
}

function tokenExistsInTable($conn, $table, $token) {
    $sql = "SELECT COUNT(*) FROM $table WHERE token = '$token'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_fetch_row($result)[0];
    return $count > 0;
}

mysqli_close($conn);
?>
