<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $district = $_POST['district'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($district != "" && $email != "" && $password != "") {
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "db";
        $conn = mysqli_connect($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT password FROM users WHERE district = ? AND email = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ss", $district, $email);
            $stmt->execute();
            $stmt->bind_result($dbPassword);
            $stmt->fetch();
            $stmt->close();

            if ($password === $dbPassword) {
                // Redirect to user1.html on successful login
                header("Location: admin1.php");
                exit();
            } else {
                 header("Location: dashboard1.php");
                exit();
            }
        }

        $conn->close();
    } else {
        echo "Please fill in all fields.";
    }
}
?>
