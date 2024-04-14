<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "db";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = mysqli_connect($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_POST["email"]) && isset($_POST["district"])) {
        $email = $_POST["email"];
        $district = $_POST["district"];

        $stmt = $conn->prepare("SELECT password FROM users WHERE email = ? AND district = ?");
        $stmt->bind_param("ss", $email, $district);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $password = $row["password"];

            // Set the recovery message
            $recoveryMessage = "Your password is: " . $password;
        } else {
            $recoveryMessage = "Email and district do not match our records.";
        }
    
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Recovery</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: url('your-background-image.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #2c5686; /* Blue background */
        }

        .card {
            width: 350px; /* Increased the card width */
            text-align: center;
            padding: 20px;
            background-color: white; /* Adjusted background opacity */
            border-radius: 15px; /* Increased border-radius for a softer look */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            position: relative;
            align-self: center;
        }

        .logo {
            max-width: 150px;
            margin-bottom: 0;
            align-self: center;
        }

        .card h1 {
            font-size: 1.5em; /* Adjusted font size for the heading */
            color: #333; /* Adjusted text color for better contrast */
        }

        .button {
            padding: 5px 35px;
            background-color: #27ae60; /* Blue button background color */
            color: #fff; /* Button text color */
            border: none;
            border-radius: 15px;
            cursor: pointer;
            text-decoration: none; /* Remove underline from text */
            transition: background-color 0.3s;
            text-align: center;

        }

        .button:hover {
            background-color: #1da56a; /* Darker blue on hover */
        }

        input[type="submit"] {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #27ae60;
        }

    </style>
</head>
<body>

<div class="card">
    <img src="../l.png" alt="Logo" width="150" class="logo mb-3">
    <h1 >Password Recovery</h1><br>
    <form method="post">
    <div class="mb-3">
                <select name="district" class="form-select" required>
                    <option value="" disabled selected>District Selector</option>
                    <option value="Mumbai">Mumbai</option>
                    <option value="Pune">Pune</option>
                    <!-- Add more districts here -->
                </select>
            </div>
            <div class="mb-3">
                <input type="text" name="email" class="form-control" placeholder="Email" required>
            </div>
            <button type="submit" class="btn btn-primary button">Get Password</button>
        </form>
         <!-- Display the recovery message -->
    <div class="mt-3">
        <?php echo $recoveryMessage; ?>
    </div>
        <div class="mt-3">
            <a href="admin.html" class="text-decoration-none">Log In </a>
        </div>
    </form>
</div>

<!-- Bootstrap JS (optional, but needed for some features) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
