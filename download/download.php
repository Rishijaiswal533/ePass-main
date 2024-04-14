<?php
// Database connection setup (Replace with your database connection details)
$host = "localhost";
$username = "root";
$password = "";
$database = "db";
$conn = mysqli_connect($host, $username, $password, $database);

// Check if the connection was successful
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Define the tables you want to check (emg, y1, y2, n2)
    $tables = ['emg', 'y1', 'y2', 'n2'];
    $status = null;

    // Check each table for the token
    foreach ($tables as $table) {
        $query = "SELECT status FROM $table WHERE token = '$token' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $status = $row['status'];
                mysqli_free_result($result); // Free the result set
                break; // Stop further checking once status is found
            }
        } else {
            echo "Error in query: " . mysqli_error($conn);
            exit;
        }
    }

    if ($status === "waiting") {
        echo "<div style='background-color: #FFD700; color: #333; padding: 20px; text-align: center; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);'>Your application is under process.</div>";
    } elseif ($status === "approved") {
        echo "<div style='background-color: #4CAF50; color: white; padding: 20px; text-align: center; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);'>Your application is approved.</div>";
    } elseif ($status === "rejected") {
        echo "<div style='background-color: #FF5733; color: white; padding: 20px; text-align: center; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);'>Your application is rejected.</div>";
    } else {
        echo "<div style='background-color: #333; color: white; padding: 20px; text-align: center; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);'>Token not found</div>";
    }

    if ($status === "waiting" || $status === "approved" || $status === "rejected") {
        if ($table === 'emg') {
            // Token found in the "emg" table, open pdf1.php and send the token in the URL
            echo "<a href='pdf1.php?token=$token' style='display: block; text-align: center; margin-top: 10px; text-decoration: none;' target='_blank'><button style='background-color: #2c5686; color: white; border: none; border-radius: 5px; padding: 10px 20px; cursor: pointer; transition: background-color 0.3s;'>View Form</button></a>";
        } else {
            // For other statuses, open pdf.php with the token
            echo "<a href='pdf.php?token=$token' style='display: block; text-align: center; margin-top: 10px; text-decoration: none;' target='_blank'><button style='background-color: #2c5686; color: white; border: none; border-radius: 5px; padding: 10px 20px; cursor: pointer; transition: background-color 0.3s;'>View Form</button></a>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    echo "No token provided.";
}

?>
