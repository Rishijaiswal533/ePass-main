<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection setup (Replace with your database connection details)
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "db";
$conn = mysqli_connect($host, $username, $password, $database);

    // Check if the connection was successful
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Get form data
    $district = $_POST["district"];
    $name = $_POST["name"];
    $serviceType = $_POST["service-type"];
    $vehicleNumber = $_POST["vehicle-number"];
    $mobileNumber = $_POST["mobile-number"];
    $email = $_POST["email"];
    $fromDate = $_POST["from-date"];
    $toDate = $_POST["to-date"];
    $reason = $_POST["reason"];
    $address = $_POST["address"];
    $token = $_POST["token"];
    $status = "waiting"; // Default status

    // SQL query to insert data into the database
    $sql = "INSERT INTO emg (district, name, service_type, vehicle_number, mobile_number, email, from_date, to_date, reason, address, token, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssssssss', $district, $name, $serviceType, $vehicleNumber, $mobileNumber, $email, $fromDate, $toDate, $reason, $address, $token, $status);

    if (mysqli_stmt_execute($stmt)) {
        // Send SMS
        require_once '../vendor/autoload.php'; // Include Twilio PHP library
        $sid = 'AC42ee22e69d3f8b03199c5faff2a852b5';
        $token1 = '006c72fb17d59c45edf5d9a00f45f1d0';
        $client = new Twilio\Rest\Client($sid, $token1);

        $smsMessage = $smsMessage = "Successfully applied for the ePass. Your Token number is $token. Download your ePass from https://epassproject.000webhostapp.com/download/download.html";
        $client->messages->create(
            $mobileNumber,
            array(
                'from' => '+16592445850',
                'body' => $smsMessage
            )
        );

        // Redirect to the download page
        $redirectURL = "../download/submit.html?token=" . urlencode($token);
        header("Location: " . $redirectURL);
        exit(); // Stop further execution
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the statement and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>

