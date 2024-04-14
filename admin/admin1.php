
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

$count_y1 = $result_y1->num_rows;

$sql_y1 = "SELECT * FROM y1";
$result_y1 = $conn->query($sql_y1);
$records_y1 = fetchData($result_y1);

$count_today = 0;
$current_date = date("Y-m-d");  // Get today's date

foreach ($records_y1 as $record) {
    $record_date = date("Y-m-d", strtotime($record['time']));  // Assuming 'time' is your date column
    
    if ($record_date === $current_date) {
        $count_today++;
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    
   <style>
           .cc{
            background-color:white;
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
                text-decoration: none;
                color: inherit;
            }
    
            .nav-drawer li:hover {
                background-color: #ffffff;
                color: rgb(0, 0, 0);
                color: rgb(96, 96, 250);
            }
    
            body {
                margin: 0;
                padding: 0;
                height: 100vh;
                display: grid;
                grid-template-columns: 15% 85%;
            }
    
            .left-grid {
                background-color: #ffffff;
                height: 100vh;
                border-right: 2px solid rgb(195, 195, 195);
            }
    
            .right-grid {
                background-color:rgb(195, 195, 195);
                height: 100vh;
                display: flex;
                flex-direction: column;
            }
    
            .top-bar {
                border-bottom: 2px solid rgb(195, 195, 195);
                background-color: #ffffff;
                height: 50px;
                color: black;
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 10px;
            }
    
            .top-bar .logo {
                display: none; /* Initially hide the logos */
            }
    
            @media screen and (max-width: 768px) {
                /* For small screens, switch to a single column layout */
                body {
                    grid-template-columns: 1fr;
                }
                .top-bar{
                    display: none;
                }
                .grid-container {
                    display:list-item;
                    justify-content: space-between;
                    width: 80%; /* Adjust the width as needed */
                }
    
                .left-grid {
                    height: auto;
                }
    
                .nav-drawer li:not(:first-child) {
                    display: none;
                }
    
                .left-grid,
                .right-grid {
                    width: 100%;
                }
    
                .nav-drawer {
                    text-align: center;
                }
    
                .nav-drawer li:first-child {
                    margin-bottom: 10px;
                }
    
                .top-bar .logo {
                    display: flex; /* Display the logos on small screens */
                }
               
            }
    
            .top-bar .logo img {
                width: 30px; /* Set the width of the logos */
                margin-right: 10px; /* Add margin between logos */
            }
            .grid-container {
                display:flex;
                justify-content: space-between;
                width: 100%; /* Adjust the width as needed */
            }
    
            .grid {
                
                margin-top: 15px;
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
            p{
                font-size: 120%;
                text-align: center;
                margin-top: 5%;
                font-family: "Gill Sans", sans-serif;
            }
            
    </style>
    
    <style>
          .col-10-scroll {
         
         height: 100%;
         width: 180vh;
         background-color: rgb(233, 233, 233);
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         padding-top: 20px;
         padding-right: 30px;
         }
        
         .container-wrapper {
        
         height: 50vh; 
         display: flex;
         flex-direction: column;
         align-items: left;
         }
         .table-container {
         width: 98%;
         
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
    <div class="left-grid">
        <ul class="nav-drawer">
            <li style="text-align: center; font-size: 1.2rem;">
                <a href="#">
                    Dashboard
                </a>
            </li>
            <li>
                <br>
                <a href="Dashboard.php" style="color:rgb(96, 96, 250);">
                   <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-window-desktop" viewBox="0 0 16 16" >
                      <path d="M3.5 11a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                      <path d="M2.375 1A2.366 2.366 0 0 0 0 3.357v9.286A2.366 2.366 0 0 0 2.375 15h11.25A2.366 2.366 0 0 0 16 12.643V3.357A2.366 2.366 0 0 0 13.625 1zM1 3.357C1 2.612 1.611 2 2.375 2h11.25C14.389 2 15 2.612 15 3.357V4H1zM1 5h14v7.643c0 .745-.611 1.357-1.375 1.357H2.375A1.366 1.366 0 0 1 1 12.643z"/>
                   </svg>
                   &ensp;Dashboard
                </a>
             </li>
            <li>
                <a href="statistics.php">
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
                    &ensp;Pass
                </a>
            </li>
            <li>
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>
                    &ensp;Logout
                </a>
            </li>
        </ul>
    </div>
    <div class="right-grid">
        <div class="top-bar d-none d-md-block">
        
        </div>
        
        <div class="col-11 col-11-scroll " >
                <div class="grid-container" style="align-content: center; margin-left:2%;">
                    <div class="grid">
                    <div style="display: flex; flex-direction: column; align-items: center; text-align: center; ">
    <h9>All Generated Pass</h9>
    <div style="display: flex; align-items: center; margin-top: 10px;">
        <h2 style="margin-right: 10px;"><?= $count_y1 ?></h2>
        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-pass" viewBox="0 0 16 16">
            <path d="M5.5 5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1z"/>
            <path d="M8 2a2 2 0 0 0 2-2h2.5A1.5 1.5 0 0 1 14 1.5v13a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-13A1.5 1.5 0 0 1 3.5 0H6a2 2 0 0 0 2 2m0 1a3.001 3.001 0 0 1-2.83-2H3.5a.5.5 0 0 0-.5.5v13a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-13a.5.5 0 0 0-.5-.5h-1.67A3.001 3.001 0 0 1 8 3"/>
        </svg>
    </div>
</div>
                        
                    </div>
                    <div class="grid">
                        <h9>Today Genrated Pass </h9>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16" style="align-items:center; margin-left:35%;margin-top:5%">
                            <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z"/>
                            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0"/>
                        </svg>
                    </div>
                    <div class="grid">
                        <h9>Statics</h9>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-clipboard-data-fill" viewBox="0 0 16 16" style="align-items:center; margin-left:35%;margin-top:5%">
                            <path d="M6.5 0A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0zm3 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5z"/>
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1A2.5 2.5 0 0 1 9.5 5h-3A2.5 2.5 0 0 1 4 2.5zM10 8a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm4-3a1 1 0 0 1 1 1v3a1 1 0 1 1-2 0v-3a1 1 0 0 1 1-1"/>
                          </svg>
                    </div>
                    <div class="grid">
                        <h9>Expierd Pass</h9>
                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16" style="align-items:center; margin-left:35%;margin-top:5%">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                          </svg>
                    </div>
                </div><br>
                
            <h3>
            <div class="cc">
            Today's Pass ( <?= $count_today ?> ) &ensp;&ensp;<i class="bi bi-search"></i>
            <h3>
            <div class="container-wrapper">
               <div class="table-container">
                  <div class="table-responsive">
                     <table class="table table-bordered">
                        <thead>
                           <div style="border: none; background-color: transparent;">
                              <div style="width: 16.666%; float: left; margin-right: 1%;margin-bottom:1%">
                                 <input type="text" class="form-control search-input" id="tokenSearch" placeholder="Token" oninput="searchTable()" style="height: 35px; border: 1px solid #ced4da; border-radius: 4px;">
                              </div>
                              <div style="width: 10.333%; float: left; margin-right: 1%;">
                                 <input type="text" class="form-control search-input" id="name" placeholder="Name" oninput="searchTable()" style="height: 35px; border: 1px solid #ced4da; border-radius: 4px;">
                              </div>
                              <div style="width: 10.333%; float: left; margin-right: 1%;">
                                 <select class="form-control search-input" id="vehicleTypeSearch" onchange="searchTable()" style="height: 35px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="" selected disabled>Select Vehicle Type</option>
                                    <option value="car">Car</option>
                                    <option value="motorcycle">Motorcycle</option>
                                    <option value="truck">Truck</option>
                                 </select>
                              </div>
                              <div style="width: 10.333%; float: left; margin-right: 1%;">
                                 <input type="text" class="form-control search-input" id="mobileNumSearch" placeholder="Mobile" oninput="searchTable()" style="height: 35px; border: 1px solid #ced4da; border-radius: 4px;">
                              </div>
                              <div style="width: 10.333%; float: left; margin-right: 1%;">
                                 <input type="text" class="form-control search-input datepicker" id="fromDateSearch" placeholder="From Date" oninput="searchTable()" style="height: 35px; border: 1px solid #ced4da; border-radius: 4px;">
                              </div>
                              <div style="width: 10.333%; float: left; margin-right: 1%;">
                                 <input type="text" class="form-control search-input datepicker" id="toDateSearch" placeholder="To Date" oninput="searchTable()" style="height: 35px; border: 1px solid #ced4da; border-radius: 4px;">
                              </div>
                              <div style="width: 10.333%; float: left; margin-right: 1%;">
                                 <select class="form-control search-input" id="fromCitySearch" onchange="searchTable()" style="height: 35px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">From</option>
                                    <option value="City1">City 1</option>
                                    <option value="City2">City 2</option>
                                 </select>
                              </div>
                              <div style="width: 10.333%; float: left;">
                                 <select class="form-control search-input" id="toCitySearch" onchange="searchTable()" style="height: 35px; border: 1px solid #ced4da; border-radius: 4px;">
                                    <option value="">Destination</option>
                                    <option value="City1">City 1</option>
                                    <option value="City2">City 2</option>
                                 </select>
                              </div>
                           </div>
                           <tr>
                              <th onclick="sortTable(0)">Token
                                 <i class="bi bi-arrow-up-down sort-icon">
                              </th>
                              <th onclick="sortTable(1)">Name
                                 <i class="bi bi-arrow-up-down sort-icon">
                              </th>
                              <th onclick="sortTable(2)">Vehicle Type 
                                 <i class="bi bi-arrow-up-down sort-icon">
                              </th>
                              <th onclick="sortTable(3)">Mobile num. 
                                 <i class="bi bi-arrow-up-down sort-icon">
                              </th>
                              <th onclick="sortTable(4)">From date 
                                 <i class="bi bi-arrow-up-down sort-icon">
                              </th>
                              <th onclick="sortTable(5)">To date
                                 <i class="bi bi-arrow-up-down sort-icon">
                              </th>
                              <th onclick="sortTable(6)">From 
                                 <i class="bi bi-arrow-up-down sort-icon">
                              </th>
                              <th onclick="sortTable(7)">Destination </th>
                              <th>View</th>
                           </tr>
                        </thead>
                        <tbody>
                           <!-- Loop through the fetched records from y1 table -->
                           <?php foreach ($records_y1 as $record) { ?>
                           <tr>
                              <td><?= $record['token'] ?></td>
                              <td><?= $record['name'] ?></td>
                              <td><?= $record['type_of_vehicle'] ?></td>
                              <td><?= $record['mobile'] ?></td>
                              <td><?= $record['from_date'] ?></td>
                              <td><?= $record['to_date'] ?></td>
                              <td><?= $record['starting_city'] ?></td>
                              <td><?= $record['ending_city'] ?></td>
                              <td>
                                 <!-- Download icon -->
                                 <a href="#" class="btn btn-success">
                                 <i class="bi bi-download" ></i>
                                 </a>
                                 <!-- Eye icon -->
                                 <a href="#" class="btn btn-primary">
                                 <i class="bi bi-eye"></i>
                                 </a>
                              </td>
                           </tr>
                           <?php } ?>
                        </tbody>
                        <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="viewModalLabel">View Record Details</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body" id="viewModalBody">
                                <!-- Detailed record information will be displayed here -->
                            </div>
                        </div>
                    </div>
                </div>
                     </table>
                  </div>
               </div>
            </div>
         </div>
            </div>
        </div>
                           </div>
        
    </div>

   <script>
         $(document).ready(function () {
             $('.datepicker').datepicker({
                 format: 'yyyy-mm-dd', // Adjust the format as needed
                 autoclose: true
             });
         });
      </script>
      <script>
         function searchTable() {
             var inputs = document.querySelectorAll('.search-input');
             var filter = [];
         
             inputs.forEach(function (input) {
                 filter.push(input.value.toUpperCase());
             });
         
             var table = document.querySelector(".table");
             var tr = table.getElementsByTagName("tr");
         
             for (var i = 1; i < tr.length; i++) { // Start from index 1 to skip the header row
                 var match = true;
                 var tds = tr[i].getElementsByTagName("td");
         
                 for (var j = 0; j < filter.length; j++) {
                     if (tds[j]) {
                         var txtValue = tds[j].textContent || tds[j].innerText;
                         if (txtValue.toUpperCase().indexOf(filter[j]) === -1) {
                             match = false;
                             break;
                         }
                     }
                 }
         
                 if (match) {
                     tr[i].style.display = "";
                 } else {
                     tr[i].style.display = "none";
                 }
             }
         }
      </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>