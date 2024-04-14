<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.2.2/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Service Details</title>
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }
        .container {
            width: 100%;
            height: 100%;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .page {
            border: 2px solid #2c5686;
            margin: 2%;
            padding: 20px;
            width: 90%;
            text-align: center;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 10px;
        }
        .table-row {
            flex: 0 1 calc(25% - 20px); /* 50% width with some margin */
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table-cell {
            padding: 20px;
            text-align: left;
        }
        .label {
            font-weight: bold;
            font-size: 16px;
            color: #2c5686;
        }
        .value {
            font-weight: bold;
            font-size: 15px;
            color: #333;
        }
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        .button {
            margin: 10px;
            padding: 15px 30px;
            cursor: pointer;
            background-color: #2c5686;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #1c405f;
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            border: 2px solid #000;
            padding: 20px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .popup-button-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }
        .abc {
            text-align: center;
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page">
            <div>
                <h3>Application View Mode</h3>
            </div>
            
            <div class="table-container">
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

                if (isset($_GET['token'])) {
                    $token = $_GET['token'];
                    $data = null;

                    // Define the tables to check
                    $tables = ['emg', 'y1', 'y2', 'n2'];

                    foreach ($tables as $table) {
                        $sql = "SELECT * FROM $table WHERE token = '$token'";
                        $result = mysqli_query($conn, $sql);

                        if ($result && mysqli_num_rows($result) > 0) {
                            $data = mysqli_fetch_assoc($result);
                            break; // Stop searching when the token is found
                        }
                    }

                    if ($data) {
                        foreach ($data as $column => $value) {
                            echo '<div class="table-row">'; 
                            echo '<div class="table-cell">';
                          
                            echo "<div class='label' id='$column'>$column: $value</div>";
                          
                            echo '</div>';
                            echo '</div>';
                        }

                        echo '<div class="button-container">';
                        echo '<form method="post" action="update_status.php">';
                        echo '<input type="hidden" name="token" value="' . $token . '">';
                       
                        echo '';
                        echo '</form>';
                       
                        echo '</div>';
                    } else {
                        echo "<h2>Service Details Not Found</h2>";
                    }
                } else {
                    echo "<h2>No Token Provided</h2>";
                }

                mysqli_close($conn);
                ?>
            </div>
        </div>
    </div>
    <div class="popup" id="popup">
        <h3 id="popup-message">Application Approved</h3>
        <div class="popup-button-container">
            <button class="button" onclick="closePopup()">Close</button>
        </div>
    </div>
    <div class="button-container">
    <form method="post" action="update_status.php">
        <input type="hidden" name="token" value="<?php echo $token; ?>">
        <div class="abc">
            <button type="submit" name="status" value="approved" class="button" style="background-color: green;">Approved</button>
            <button type="submit" name="status" value="rejected" class="button" style="background-color: red;">Reject</button>
            <button type="button" class="button" onclick="goBack()" style="background-color: #2c5686;">Go Back</button>
        </div>
    </form>
</div>
<br><br><br><br>
    <script>
        function goBack() {
            history.back();
            history.back();
        }
    
        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
</body>
</html>
