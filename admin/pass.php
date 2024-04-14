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
$sql_y1 = "SELECT *, 'y1' as type FROM y1";
$result_y1 = $conn->query($sql_y1);
$records_y1 = fetchData($result_y1);
$count_y1 = count($records_y1);

// Fetch data from y2 table
$sql_y2 = "SELECT *, 'y2' as type FROM y2";
$result_y2 = $conn->query($sql_y2);
$records_y2 = fetchData($result_y2);
$count_y2 = count($records_y2);

// Fetch data from n2 table
$sql_n2 = "SELECT *, 'n2' as type FROM n2";
$result_n2 = $conn->query($sql_n2);
$records_n2 = fetchData($result_n2);
$count_n2 = count($records_n2);

// Fetch data from emg table
$sql_emg = "SELECT *, 'emergency' as type FROM emg";
$result_emg = $conn->query($sql_emg);
$records_emg = fetchData($result_emg);
$count_emg = count($records_emg);
$total_count = $count_y1 + $count_y2 + $count_n2 + $count_emg;

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
         width: 190vh;
         background-color: rgb(233, 233, 233);
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
         padding-top: 20px;
         padding-right: 30px;
         }
         body {
         margin: 0;
         padding: 0;
         overflow: hidden;
         }
         .container-wrapper {
         height: 80vh; 
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
         font-size: 12px; /* Default font size for data cells */
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
         font-size: 10px;
         }
         th {
         font-size: 10px;
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
                  <a href="../Dashboard1.php" >
                     <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-window-desktop" viewBox="0 0 16 16" >
                        <path d="M3.5 11a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
                        <path d="M2.375 1A2.366 2.366 0 0 0 0 3.357v9.286A2.366 2.366 0 0 0 2.375 15h11.25A2.366 2.366 0 0 0 16 12.643V3.357A2.366 2.366 0 0 0 13.625 1zM1 3.357C1 2.612 1.611 2 2.375 2h11.25C14.389 2 15 2.612 15 3.357V4H1zM1 5h14v7.643c0 .745-.611 1.357-1.375 1.357H2.375A1.366 1.366 0 0 1 1 12.643z"/>
                     </svg>
                     &ensp;Dashboard
                  </a>
               </li>
               <li>
                  <a href="../statistics.php">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-graph-up-arrow" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M0 0h1v15h15v1H0zm10 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V4.9l-3.613 4.417a.5.5 0 0 1-.74.037L7.06 6.767l-3.656 5.027a.5.5 0 0 1-.808-.588l4-5.5a.5.5 0 0 1 .758-.06l2.609 2.61L13.445 4H10.5a.5.5 0 0 1-.5-.5"/>
                     </svg>
                     &ensp;Statistics
                  </a>
               </li>
               <li>
                  <a href="../city.php">
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.319 1.319 0 0 0-.37.265.301.301 0 0 0-.057.09V14l.002.008a.147.147 0 0 0 .016.033.617.617 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.619.619 0 0 0 .146-.15.148.148 0 0 0 .015-.033L12 14v-.004a.301.301 0 0 0-.057-.09 1.318 1.318 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465-1.281 0-2.462-.172-3.34-.465-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411"/>
                     </svg>
                     &ensp;City
                  </a>
               </li>
               <li>
                  <a href="#"style="color:rgb(96, 96, 250);>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-passport" viewBox="0 0 16 16">
                     <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6M6 8a2 2 0 1 1 4 0 2 2 0 0 1-4 0m-.5 4a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1z"/>
                     <path d="M3.232 1.776A1.5 1.5 0 0 0 2 3.252v10.95c0 .445.191.838.49 1.11.367.422.908.688 1.51.688h8a2 2 0 0 0 2-2V4a2 2 0 0 0-1-1.732v-.47A1.5 1.5 0 0 0 11.232.321l-8 1.454ZM4 3h8a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1"/>
                  </svg>
                  &ensp;Pass</a>
               </li>
               <li>
                  <a href="../admin.html" >
                     <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                        <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                     </svg>
                     &ensp;Logout
                  </a>
               </li>
            </ul>
            </div>
          
            <div class="col-10 col-10-scroll " >
            <div>
            <div>
            <div style="margin-bottom: 15px; background-color: #f8f9fa; padding: 15px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <label for="passTypeFilter" style="font-size: 16px; margin-right: 10px;">View By State</label>
    <select class="form-control search-input" id="passTypeFilter" onchange="searchTable()" style="height: 35px; border: 1px solid #ced4da; border-radius: 4px;">
        <option value="" selected>All Passes</option>
        <option value="emergency">Emergency Pass</option>
        <option value="n2">Interstate Pass</option>
        <option value="y1">Out of State Pass</option>
        <option value="y2">Out of State (More than 5 persons)</option>
    </select>
</div>

</div>
</div>
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
                              <th>TYPE</th>
                              <th>View</th>
                           </tr>
                        </thead>
                        <tbody>
                          <!-- Loop through the fetched records from y1, y2, n2, and emg tables -->
<?php foreach (array_merge($records_y1, $records_y2, $records_n2, $records_emg) as $record) { ?>
    <tr>
                <td><?= $record['token'] ?></td>
                <td><?= $record['name'] ?></td>
                <td><?= $record['type_of_vehicle'] ?></td>
                <td><?= $record['mobile'] ?></td>
                <td><?= $record['from_date'] ?></td>
                <td><?= $record['to_date'] ?></td>
                <td><?= $record['starting_city'] ?></td>
                <td><?= $record['ending_city'] ?></td>
                <td><?= $record['type'] ?></td> 
                <!-- Display the 'type' column -->
                <td>
                    <!-- Download icon -->
                    <a href="#" class="btn btn-success" onclick="openUrl('http://localhost/epass-main/download/pdf.php?token=<?= $record['token'] ?>')">
                        <i class="bi bi-download"></i>
                    </a>
                    <!-- Eye icon -->
                    <a href="#" class="btn btn-primary" onclick="openUrl('http://localhost/epass-main/admin/view.php?token=<?= $record['token'] ?>')">
                        <i class="bi bi-eye"></i>
                    </a>
                </td>
            </tr>
<?php } ?>

<script>
    function openUrl(url) {
        window.location.href = url;
    }
</script>

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
      <script>
function searchTable() {
    var passTypeFilter = document.getElementById('passTypeFilter').value.toUpperCase();
    var table = document.querySelector(".table");
    var tr = table.getElementsByTagName("tr");

    for (var i = 1; i < tr.length; i++) {
        var tds = tr[i].getElementsByTagName("td");
        var typeColumn = tds[8].textContent.toUpperCase(); // Assuming 'type' column is at index 8

        if (passTypeFilter === '' || typeColumn === passTypeFilter) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
}
</script>
            </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>