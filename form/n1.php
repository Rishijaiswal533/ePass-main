<?php
// Set error reporting to display all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define your database connection parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "db"; // Replace with your actual database name

// Connect to the database
$conn = new mysqli($host, $username, $password, $database);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a 17-digit token (3 alphabets + 14 numbers)
function generateToken() {
    $alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $token = substr(str_shuffle($alphabet), 0, 3) . mt_rand(10000000000000, 99999999999999);
    return $token;
}

// Initialize token
$token = "";

// Process the form data when it's submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a 17-digit token
    $token = generateToken();

      // Extract data from the form
      $district = $_POST["district"];
      $name = $_POST["name"];
      $from_date = $_POST["from_date"];
      $to_date = $_POST["to_date"];
      $mobile = $_POST["mobile"];
      $reason_for_travel = $_POST["reason_for_travel"];
      $brief_reason = $_POST["brief_reason"];
      $type_of_vehicle = $_POST["type_of_vehicle"];
      $vehicle_num = $_POST["vehicle_num"];
      $current_address = $_POST["current_address"];
      $email = $_POST["email"];
      $starting_city = $_POST["starting_city"];
      $ending_city = $_POST["ending_city"];
      $num_of_passengers = $_POST["num_of_passengers"];
      $address_of_destination = $_POST["address_of_destination"];
      $containment_zone = $_POST["containment_zone"];

    // Initialize variables to store co-passenger data
    $p1 = "";
    $p2 = "";
    $p3 = "";
    $p4 = "";

    // Loop through each co-passenger container and store the data
    for ($i = 1; $i <= 4; $i++) {
        $passengerName = $_POST["passenger" . $i . "_name"];
        $passengerAge = $_POST["passenger" . $i . "_age"];
        $passengerGender = $_POST["passenger" . $i . "_gender"];
        $passengerAadhar = $_POST["passenger" . $i . "_aadhar"];

        // Store the co-passenger data in the appropriate variable
        if ($i == 1) {
            $p1 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        } elseif ($i == 2) {
            $p2 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        } elseif ($i == 3) {
            $p3 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        } elseif ($i == 4) {
            $p4 = "$passengerName , $passengerAge , $passengerGender , $passengerAadhar";
        }
    }

    // Insert the data into the database, including co-passenger data
    $sql = "INSERT INTO n2 (token, district, name, from_date, to_date, mobile, reason_for_travel, 
    brief_reason, type_of_vehicle, vehicle_num, current_address, email, starting_city, ending_city, num_of_passengers, 
    address_of_destination, containment_zone, outofstate, status, p1, p2, p3, p4) 
    VALUES ('$token', '$district', '$name', '$from_date', '$to_date', '$mobile', '$reason_for_travel', 
    '$brief_reason', '$type_of_vehicle', '$vehicle_num', '$current_address', '$email', '$starting_city', '$ending_city', 
    '$num_of_passengers', '$address_of_destination', '$containment_zone', 'NO', 'waiting', '$p1', '$p2', '$p3', '$p4')";

    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt && mysqli_stmt_execute($stmt)) {
        require_once '../vendor/autoload.php';
        $sid = 'AC42ee22e69d3f8b03199c5faff2a852b5';
        $token1 = '006c72fb17d59c45edf5d9a00f45f1d0';
        $client = new Twilio\Rest\Client($sid, $token1);

        $smsMessage = "Successfully applied for the ePass. Your Token number is $token. Download your ePass from https://epassproject.000webhostapp.com/download/download.html";

        $client->messages->create(
            $mobile,
            array(
                'from' => '+16592445850',
                'body' => $smsMessage
            )
        );

        $redirectURL = "../download/submit.html?token=" . urlencode($token);
        header("Location: " . $redirectURL);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>