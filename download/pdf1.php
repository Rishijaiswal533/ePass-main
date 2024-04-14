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
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .page {
            border: 5px solid #000;
            margin-top: 5%;
            padding: 15px;
            width: 60%;

            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 10%;
            background-color: #1b1b6c;
        }

        .header img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .hindi-heading {
            font-size: 16px;
            color: #333;
            margin-bottom: 10px;
        }

        .content {
            margin-top: 15px;
        }

        .marathi-heading {
            font-size: 28px;
            color: #1b1b6c;
            margin-bottom: 15px;
        }

        .barcode {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 15px;
        }

        .download-button {
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            cursor: pointer;
            display: block;
            margin: 15px auto;
        }

        p {
            text-align: left;
            font-size: 16px;
            margin: 0;
            color: #333;
        }

        h1 {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
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

            if (isset($_GET['token'])) {
                $token = $_GET['token'];
                $query = "SELECT id, district, vehicle_number, name, service_type, mobile_number, email, from_date, to_date, reason, address, passport_photo, medical_report, status FROM emg WHERE token = '$token' LIMIT 1";
                $result = mysqli_query($conn, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_assoc($result);
                    $status = $row['status'];
                    
                    if ($status === 'approved') {
                        echo '<div style="background-color: green ;"><h1 style="color: white;">Your application is approved</h1></div>';
                    } elseif ($status === 'rejected') {
                        echo '<div style="background-color: red;"><h1>Your application is rejected</h1></div>';
                    } elseif ($status === 'waiting') {
                        echo '<div style="background-color: yellow;"><h1>Your application is waiting for approval</h1></div>';
                    }

                    echo "<div class='marathi-heading'>\"अत्यंत आवश्यक सेवा\"</div>";
                    echo "<div class='content'>";
                    echo '<img src="data:image/jpeg;base64,' . base64_encode($row['medical_report']) . '" />';
                    echo "<p>Name: - " . $row['name'] . "</p><hr>";
                    echo "<p>Address: - " . $row['address'] . "</p><hr>";
                    echo "<p>Vehicle Number: - " . $row['vehicle_number'] . "</p><hr>";
                    echo "<p>Valid Date: - " . $row['from_date'] . " to " . $row['to_date'] . "</p><hr>";
                    echo "<div class='marathi-heading'>\"या अत्यंत आवश्यक सेवा देण्यासाठी " . $row['district'] . "  संचार दरम्यान प्रवास करण्यास सुट्ट देण्यात आली आहे\"</div>";
                    echo "<div class='barcode' id='qr-code'></div>";
                    echo "<p>Service Type: " . $row['service_type'] . "<hr></p>";
                    echo "</div>";
                }
            }
            ?>
            <button id="download-button" class="btn btn-success" onclick="printAsPDF()" style="background-color: green; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; display: block; margin-left:42%;">Download</button>
            
        </div>
        
    </div>
    <script>
        var qrcode = new QRCode(document.getElementById("qr-code"), {
            text: "<?php echo $_GET['token']; ?>",
            width: 128,
            height: 128
        });

        var downloadButton = document.getElementById("download-button");

        downloadButton.addEventListener("click", function() {
            html2canvas(document.querySelector('.page')).then(canvas => {
                var imgData = canvas.toDataURL('image/jpeg');
                var pdf = new jsPDF('p', 'mm', 'a4');
                pdf.addImage(imgData, 'JPEG', 0, 0);
                pdf.save('service_details.pdf');
            });
        });
        function printAsPDF() {
            window.print(); // Trigger the browser's print dialog
        }
    </script>
</body>
</html>
