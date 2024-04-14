<?php
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

// Function to get status count
function getStatusCount($conn, $status) {
    $count = 0;
    $tables = ['emg', 'y1', 'y2', 'n2'];
    foreach ($tables as $table) {
        $query = "SELECT COUNT(*) AS count FROM $table WHERE status = '$status'";
        $result = mysqli_query($conn, $query);
        if ($result) {
            $row = mysqli_fetch_assoc($result);
            $count += $row['count'];
        }
    }
    return $count;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Admin</title>

    <style>
        .grid-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
}

.grid-item {
    flex-basis: calc(50% - 10px); /* Two grid items in a row with spacing */
    padding: 10px;
    margin-bottom: 20px;

    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, transform 0.2s;
}
.grid-item1 {
    flex-basis: calc(100% - 10px); /* Two grid items in a row with spacing */
    padding: 5px;
    margin-bottom: 20px;
    
    border: 1px solid #ccc;
    border-radius: 5px;
    text-align: center;
    box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s, transform 0.2s;
}

.grid-item:hover {

    transform: translateY(-2px);
}

.grid-item h2 {
    font-size: 1.5rem;
    margin: 10px 0;
}

.grid-item button {
    background-color: green;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}
.grid-item1 button {
    background-color: green;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
}

.grid-item button:hover {
    background-color: darkgreen; /* Hover color for the button */
}
.grid-item1 button:hover {
    background-color: darkgreen; /* Hover color for the button */
}
#subList {
            display: none;
            position: absolute;
        }

        body {
            width: 100%;
            height: 100%;
            background-color: antiquewhite;
            margin: 0;
            overflow: hidden;
        }
        .container-fluid {
            width: 100%;
            background-color: rgb(48, 48, 48);
            height: 8%;
            box-shadow: brown;
        }
        #e2 {
            color: aliceblue;
            font-size: 22px;
            background-color: rgb(102, 127, 161);
        }
        button {
            background-color: green;
            color: aliceblue;
            border: 0;
            margin: 5%;
            margin-right: 15%;
        }
        .container-fluid1 {
            width: 100%;
            height: 100%;
            background-color: antiquewhite;
            margin: 0;
        }
        .grid {
            width: 100%;
            height: 100%;
            background-color: white;
            margin: 0;
            overflow: hidden;
        }

        #container {
            display: flex;
            height: 100vh;
        }

        #left-column {
            color: rgb(234, 238, 241);
            font-size: 22px;
            flex: 2;
            background-color: rgb(48, 48, 48);
            overflow: auto;
        }

        #right-column {
            margin:1px;
            flex: 10;
            background-color: #c2c4cb;
            padding: 20px;
            color: black;
            overflow: auto;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 0;
            padding: 0;
            border: 2px solid transparent;
            transition: background-color 0.3s, border-color 0.3s;
        }

        li:hover {
            background-color: #212121; /* Selected page color */
            border-color: rgb(73, 73, 73);
        }

        .selected {
            background-color: #212121; /* Selected page color */
            border-color: rgb(73, 73, 73);
        }
        #row1 {
            background-color: #2c5686;
            text-align: center;
        }
        .container-row {
            width: 60%;
            
        }

        a {
            font-size: 70%;
            text-decoration: none;
            color: white;
            display: block;
            padding: 5px;
            width: 100%; /* Set width to 100% to cover the entire container */
        }
        #aa{
            background-color: white;
            margin: 0%;
        }
        
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 d-flex align-items-center" id="e2">Covid-19 ePass</div>
            <div class="col-8"></div>
            <div class="col-2 d-flex align-items-center">
                <button>Approved-list</button>
                <img src="./profile1.png" alt="Profile Image" class="img-fluid rounded-circle" style="width: 20px; height: 20px;">
            </div>
        </div>
    </div>
    <div id="container" ">
        <div id="left-column" class="col-2">
            <nav style="margin-top: 10%;">
                <ul>
                    <li class="selected"><a href="#">Dashboard</a></li>
                    <li><a href="#">Statistics</a></li>
                    <li><a href="gn.php">Registration Form</a></li>
                    <li><a href="city.php">Incoming Pass List</a></li>
                    <li>
                        <a href="#" style="text-decoration: none;" onclick="toggleOptions('subList')">Pass List</a>
                        <ul id="subList">
                            <li>
                                <a href="#" style="text-decoration: none; color: lightgreen;" onclick="viewStatus('approved')">
                                    Approved (<?php echo getStatusCount($conn, "approved"); ?>)
                                </a>
                            </li>
                            <li>
                                <a href="#" style="text-decoration: none; color: naviblue;" onclick="viewStatus('expired')">
                                    Expired (<?php echo getStatusCount($conn, "expired"); ?>)
                                </a>
                            </li>
                            <li>
                                <a href="#" style="text-decoration: none;color: goldenrod;" onclick="viewStatus('waiting')">
                                    Pending (<?php echo getStatusCount($conn, "waiting"); ?>)
                                </a>
                            </li>
                            <li>
                                <a href="#" style="text-decoration: none; color: Red;" onclick="viewStatus('rejected')">
                                    Rejected (<?php echo getStatusCount($conn, "rejected"); ?>)
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
        <div id="right-column" >
            <div class="container-fluid" style="width: 95%;">
                <div class="container-fluid1" >
                    <div class="row" id="row1">
                        <div class="col-12">
                            <img src="../apply/logo.png" alt="Centered Image" class="custom-image" style="width: 70px; margin:5px">
                        </div>
                        <div class="col-12" id="aa">
                           <h2>ePass Dashboard</h2>
                           
                <div class="grid-container">

                                <div class="grid-item1" style="background-color: #e0e0ff;">                        
                                    <h2 style="color:  darkblue;">Report a Pass coming from another city (<?php echo getStatusCount($conn, "waiting"); ?>)</h2>
                                    <button onclick="openCityPage('waiting')">View Pass</button>
                                </div>
                           
     <div class="grid-item" style="background-color: #ffffe0">
        <h2 style="color: darkgoldenrod;">Pending Applications (<?php echo getStatusCount($conn, "waiting"); ?>)</h2>
        <button onclick="viewStatus('waiting')">View</button>
    </div>
    <div class="grid-item" style="background-color: #e2f9e2;">
        <h2 style="color: darkgreen;">Approved Applications (<?php echo getStatusCount($conn, "approved"); ?>)</h2>
        <button onclick="viewStatus('approved')">View</button>
    </div>
    <div class="grid-item" style="background-color: #ffe0e0;">
        <h2 style="color: Red;">Rejected Applications (<?php echo getStatusCount($conn, "rejected"); ?>)</h2>
        <button onclick="viewStatus('rejected')">View</button>
    </div>
    <div class="grid-item" style="background-color: #e0e0ff;">
        <h2 style="color: darkblue;">Expired Applications (<?php echo getStatusCount($conn, "expired"); ?>)</h2>
        <button onclick="viewStatus('expired')">View</button>
    </div>

    <div class="grid-item1" style="background-color: #ffffe0">                        
                                    <h2 style="color:  darkblue;">Generate New ePass </h2>
                                    <button onclick="gn()">Generate</button>
                                </div>
</div>

<br> <br><br> <br><br> <br>

                        </div>
                        
                    </div>
                    <script>
                        
                        function viewStatus(status) {
                            window.location.href = `status.php?status=${status}`;
                        }
                        function openCityPage(status) {
                             window.location.href = `city.php?status=${status}`;
                        }
                        function gn() {
                             window.location.href = `gn.php`;
                        }
    
                    </script>
                    <script>
                        function toggleOptions(id) {
                            const options = document.getElementById(id);
                            options.style.display = options.style.display === 'block' ? 'none' : 'block';
                        }
                    </script>

                   
                </div>
            </div>
            <br> <br><br> <br><br> <br>
        </div>
        <br> <br><br> <br><br> <br>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
// Close the database connection
mysqli_close($conn);
?>
