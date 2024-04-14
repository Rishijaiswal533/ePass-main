<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from y1 table
$sql_y1 = "SELECT * FROM y1";
$result_y1 = $conn->query($sql_y1);
$records_y1 = fetchData($result_y1);
$count_y1 = count($records_y1);

// Fetch data from y2 table
$sql_y2 = "SELECT * FROM y2";
$result_y2 = $conn->query($sql_y2);
$records_y2 = fetchData($result_y2);
$count_y2 = count($records_y2);

// Fetch data from n2 table
$sql_n2 = "SELECT * FROM n2";
$result_n2 = $conn->query($sql_n2);
$records_n2 = fetchData($result_n2);
$count_n2 = count($records_n2);

// Fetch data from emg table
$sql_emg = "SELECT * FROM emg";
$result_emg = $conn->query($sql_emg);
$records_emg = fetchData($result_emg);
$count_emg = count($records_emg);
$total_count = $count_y1 + $count_y2 + $count_n2 + $count_emg;

$count_today = 0;
$count_expired_today = 0;
$current_date = date("Y-m-d");  // Get today's date

foreach (array_merge($records_y1, $records_y2, $records_n2, $records_emg) as $record) {
    $record_date = date("Y-m-d", strtotime($record['time']));  // Assuming 'time' is your date column
    
    if ($record_date === $current_date) {
        $count_today++;
    }

    // Check for expired passes
    $expiry_date = date("Y-m-d", strtotime($record['expiry_date']));  // Assuming 'expiry_date' is your expiry date column
    if ($expiry_date === $current_date) {
        $count_expired_today++;
    }
}

$tables = ['y1', 'y2', 'n2', 'emg'];

// Initialize arrays for type, status, and city
$typeData = [];
$statusData = [];
$cityData = [];

foreach ($tables as $table) {
    // Fetch data from the current table
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $records = fetchData($result);

    // Process data for each column
    foreach ($records as $record) {
        // Count by type
        $type = $record['type'];
        $typeData[$table][$type] = isset($typeData[$table][$type]) ? $typeData[$table][$type] + 1 : 1;

        // Count by status
        $status = $record['status'];
        $statusData[$table][$status] = isset($statusData[$table][$status]) ? $statusData[$table][$status] + 1 : 1;

        // Count by city
        $city = $record['city'];
        $cityData[$table][$city] = isset($cityData[$table][$city]) ? $cityData[$table][$city] + 1 : 1;
    }
}

// Close connection
$conn->close();

function fetchData($result) {
    $records = [];
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $records[] = $row;
        }
    }
    return $records;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f1f1f1;
            margin: 0;
        }
     
        .container-fluid, .container-fluid2 {
            background-color: white;
            width: 100%;
            margin-left: 0%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .row {
            position: fixed;
            top: 0;
            width: 100%;
            height: 8%;
            background-color: white;
        }

        #row2 {
            position: fixed;
            top: 8%;
            width: 100%;
            height: 92vh;
            background-color: white;
        }

        h4, h5, h6 {
            display: flex;
            align-items: center;
            font-family: "Gill Sans", sans-serif;
            height: 100%;
            margin: 0;
        }

        h4 {
            justify-content: center;
            text-align: center;
            font-size: 1.5rem;
        }

        h5 {
            margin-top: 3%;
            text-align: right;
            font-size: 1rem;
        }

        h6 {
            margin-left: 3%;
            font-size: 1rem;
        }

        .profile-img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Add styles for the profile modal */
        #profileModal .modal-dialog {
            max-width: 300px;
        }

        #profileModal .modal-content {
            padding: 20px;
        }

        #profileModal img {
            width: 100%;
            border-radius: 50%;
        }

        .container-fluid2 {
            margin-top: 8%;
        }

        .col-10-scroll {
            overflow-y: auto;
            height: 100%;
            background-color: rgb(233, 233, 233);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Styles for the navigation drawer */
        .nav-drawer {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-drawer li {
            margin-top: 10px;
            font-family: "Gill Sans", sans-serif;
            font-size: 1rem;
            color: black;
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
            padding: 10px;
            border-radius: 5px;
        }

        .nav-drawer li a {
            text-decoration: none; /* Remove underline */
            color: inherit; /* Inherit the color from the parent li */
        }

        .nav-drawer li:hover {
            background-color: #ffffff;
            color: rgb(0, 0, 0);
            color:rgb(96, 96, 250);
        }
        .grid-container {
            
            display: flex;
            justify-content: space-between;
            width: 100%; /* Adjust the width as needed */
        }

        .grid {
          
            flex: 1;
            height: 125px; /* Set the height as needed */
            border-radius: 5%;
            margin-right: 5%; /* Adjust the gap between grids */
            display: flex;
            flex-direction: column;
            color: white;
            font-size: 18px;
            align-items: center;
        }

        .grid:nth-child(1) {
          
            background-color: #4285F4;
        }

        .grid:nth-child(2) {
            background-color:#14ca72; 
        }

        .grid:nth-child(3) {
            background-color: #737373;
        }

        .grid:nth-child(4) {
            background-color: #F25022; 
        }
        h9{
            font-size: 120%;
            text-align: center;
            margin-top: 5%;
            font-family: "Gill Sans", sans-serif;
        }
        
       
    </style>
    <style>
          .col-10-scroll {
    
         height: 100%;
         width: 100vh;
         background-color: rgb(233, 233, 233);
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         padding-top: 20px;
         padding-right: 30px;
         baground-color:white;
         }
         body {
         margin: 0;
         padding: 0;
         overflow: hidden;
         }
         .container-wrapper {
         height: 50vh; 
         display: flex;
         flex-direction: column;
         align-items: left;
         }
         .table-container {
         width: 98%;
         border-redius:5px;
         overflow-x: auto;
         }
         .table-responsive {
         width: 100%;
         overflow-x: auto;
         }
         th, td {
         background-color: white;
         white-space: nowrap;
         text-overflow: ellipsis;
         font-size: 15px; /* Default font size for data cells */
         }
         th {
         cursor: pointer;
         font-size: 15px; /* Default font size for headings */
         }
         .table thead th {
         background-color: #007bff;
         color: #fff;
         }
         /* Adjust font size for smaller screens */
         @media screen and (max-width: 10000px) {
         th, td {
         font-size: 12px;
         }
         th {
         font-size: 12px;
         }
         }
         /* Adjust font size for even smaller screens */
         @media screen and (max-width: 800px) {
         th, td {
         font-size: 8px;
         }
         th {
         font-size: 8px;
         }
         }
         /* Adjust font size for even smaller screens */
         @media screen and (max-width: 700px) {
         th, td {
         font-size: 6px;
         }
         th {
         font-size: 6px;
         }
         }
         .search-input{
         height:30%;
         margin:0%
         }
      </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 d-flex align-items-center justify-content-center" style="border-right: 1.5px solid #ddd;">
                <h4>Demo</h4>
            </div>
            <div class="col-8 d-flex align-items-center" style="border-bottom: 1.5px solid #ddd;">
                <h4>Dashboard</h4>
            </div>
            <div class="col-2 d-flex align-items-center justify-content-center" id="profile" style="border-bottom: 1.5px solid #ddd;">
                <h4>Profile <i style="margin-left: 20%;" class="bi bi-person-check"></i></h4>
            </div>
        </div>
        <div class="row" id="row2">
            <div class="col-2" style="border-right: 1.5px solid #ddd;">
                <!-- Navigation Drawer Content -->
                <ul class="nav-drawer" style="margin-top: 10%; ">
               <li>
                  <a href="Dashboard1.php" >
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-window-desktop" viewBox="0 0 16 16" >
                        <path d="M3.5 11a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                        <path d="M2.375 1A2.366 2.366 0 0 0 0 3.357v9.286A2.366 2.366 0 0 0 2.375 15h11.25A2.366 2.366 0 0 0 16 12.643V3.357A2.366 2.366 0 0 0 13.625 1zM1 3.357C1 2.612 1.611 2 2.375 2h11.25C14.389 2 15 2.612 15 3.357V4H1zM1 5h14v7.643c0 .745-.611 1.357-1.375 1.357H2.375A1.366 1.366 0 0 1 1 12.643z"/>
                     </svg>
                     &ensp;Dashboard
                  </a>
               </li>
               <li>
                  <a href="#"style="color:rgb(96, 96, 250);>
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                     </svg>
                     &ensp;Statistics
                  </a>
               </li>
               <li>
                  <a href="city.php">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411"/>
                     </svg>
                     &ensp;City
                  </a>
               </li>
               <li>
                  <a href="pass.php">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-passport" viewBox="0 0 16 16">
                     <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6M6 8a2 2 0 1 1 4 0 2 2 0 0 1-4 0m-.5 4a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
                     <path d="M3.232 1.776A1.5 1.5 0 0 0 2 3.252v10.95c0 .445.191.838.49 1.11.367.422.908.688 1.51.688h8a2 2 0 0 0 2-2V4a2 2 0 0 0-1-1.732v-.47A1.5 1.5 0 0 0 11.232.321l-8 1.454ZM4 3h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1"/>
                  </svg>
                  &ensp;Pass</a>
               </li>
               <li>
                  <a href="admin.html" >
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                     </svg>
                     &ensp;Logout
                  </a>
               </li>
            </ul>
            </div>
            <div class="col-10 col-10-scroll">
    <!-- Create a container for the "Type" comparison chart -->
    <div class="col-md-8 mt-4 bg-white rounded mx-auto p-4">
        <canvas id="typeComparisonChart" width="400" height="300"></canvas>
    </div>
    <!-- Create a container for the "Status" comparison chart -->
    <div class="col-md-8 mt-4 bg-white rounded mx-auto p-4">
        <canvas id="statusComparisonChart" width="400" height="300"></canvas>
    </div>
    <!-- Create a container for the "City" comparison chart -->
    <div class="col-md-8 mt-4 bg-white rounded mx-auto p-4">
        <canvas id="cityComparisonChart" width="400" height="300"></canvas>
    </div>
</div>

<script>
// Your JavaScript code here

// Function to generate random colors
function getRandomColor() {
    return `rgba(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, 0.7)`;
}

// Function to create and configure a bar chart
function createBarChart(chartId, labels, datasets, chartLabel) {
    console.log(`Creating chart for ${chartId}`);
    console.log(labels, datasets);

    var ctx = document.getElementById(chartId).getContext('2d');
    return new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                title: {
                    display: true,
                    text: chartLabel
                }
            }
        }
    });
}

// Your data
var typeData = <?php echo json_encode($typeData); ?>;
var statusData = <?php echo json_encode($statusData); ?>;
var cityData = <?php echo json_encode($cityData); ?>;

// Chart configurations
var typeLabels = Object.keys(typeData['y2']);
var statusLabels = Object.keys(statusData['y1']);
var cityLabels = Object.keys(cityData['y1']);

var typeDatasets = [];
var statusDatasets = [];
var cityDatasets = [];

for (var table in typeData) {
    // Exclude 'y1' and include only 'y2', 'n2', and 'emg'
    if (table !== 'y1') {
        typeDatasets.push({
            label: table.replace('y2', 'Out of State > 5 People').replace('n2', 'Interstate').replace('emg', 'Emergency'),
            data: Object.values(typeData[table]),
            backgroundColor: getRandomColor(),
            borderColor: getRandomColor(),
            borderWidth: 1
        });
    }
}

for (var table in statusData) {
    statusDatasets.push({
        label: table.replace('y1', 'Out of State').replace('y2', 'Out of State > 5 People').replace('n2', 'Interstate').replace('emg', 'Emergency'),
        data: Object.values(statusData[table]),
        backgroundColor: getRandomColor(),
        borderColor: getRandomColor(),
        borderWidth: 1
    });
}

for (var table in cityData) {
    cityDatasets.push({
        label: table.replace('y1', 'Out of State').replace('y2', 'Out of State > 5 People').replace('n2', 'Interstate').replace('emg', 'Emergency'),
        data: Object.values(cityData[table]),
        backgroundColor: getRandomColor(),
        borderColor: getRandomColor(),
        borderWidth: 1
    });
}

// Create all three charts
createBarChart('typeComparisonChart', typeLabels, typeDatasets, 'Type Comparison');
createBarChart('statusComparisonChart', statusLabels, statusDatasets, 'Status Comparison');
createBarChart('cityComparisonChart', cityLabels, cityDatasets, 'City Comparison');
</script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>