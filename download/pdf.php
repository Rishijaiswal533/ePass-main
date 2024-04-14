<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel ePass</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            margin-top:5%;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .page {
            border: 5px solid #000;
            margin: 5%;
            padding: 15px;
            width: 80%;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #1b1b6c;
            padding: 10px;
        }

        .header img {
            border-radius: 50%;
            margin-right: 10px;
        }

        h1 {
            font-size: 24px;
            color: #1b1b6c;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: left;
        }

        p {
            font-size: 16px;
            text-align: left;
            color: #333;
        }

        .barcode {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .download-button {
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 15px 30px;
            cursor: pointer;
            display: block;
            margin: 20px auto;
        }

        @media (max-width: 768px) {
            .page {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="page">
            
            <?php
                $host = "localhost";
                $username = "root";
                $password = "";
                $database = "db";
                $conn = mysqli_connect($host, $username, $password, $database);

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                function displayTableRow($label, $value) {
                    echo "<tr><th>$label</th><td>$value</td></tr>";
                }

                if (isset($_GET['token'])) {
                    $token = $_GET['token'];
                    $tables = ['y1', 'y2', 'n2'];
                    $table_name = '';

                    foreach ($tables as $table) {
                        $query = "SELECT * FROM $table WHERE token = '$token'";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            $table_name = $table;
                            break;
                        }
                    }

                    if (!empty($table_name)) {
                        $query = "SELECT * FROM $table_name WHERE token = '$token'";
                        $result = mysqli_query($conn, $query);
                        
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            $travel_pass = ($row['outofstate'] == "Yes") ? "All Over India" : "Maharashtra Only";

                            echo "<h1>Travel ePass - $travel_pass</h1>";
                            echo "<table>";
                            displayTableRow('Name', $row['name']);
                            displayTableRow('From Date - To Date', $row['from_date'] . " - " . $row['to_date']);
                            displayTableRow('Vehicle Number', $row['vehicle_num']);
                            displayTableRow('Travel From - To', $row['starting_city'] . " - " . $row['end_city']);
                            displayTableRow('Reason of Travel', $row['reason_for_travel']);

                            $co_passengers = array_filter([$row['p1'], $row['p2'], $row['p3'], $row['p4'], $row['p5'], $row['p6']]);
                            displayTableRow('Name of Co-passengers', implode("<br>", $co_passengers));
                            echo "</table>";
                        }
                    }
                }
            ?>
            <div class="barcode" id="qr-code"></div>
            <p style="text-align: center; font-size: 16px; color: #333;">
    This is a computer-generated QR code verifiable pass. Please carry original ID proof.<br>
</p>
<button id="download-button" onclick="printAsPDF()" style="background-color: green; color: white; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; display: block; margin: 20px auto;">
    Download
</button>

    </div>

    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
    <script>
        var qrcode = new QRCode(document.getElementById("qr-code"), {
            text: "<?php echo $token; ?>",
            width: 128,
            height: 128
        });

        function printAsPDF() {
            window.print();
        }
    </script>
</body>
</html>
