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
    <meta http-equiv="X-UA-Compatible" content="IE edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Admin</title>
    <style>
    /* Apply consistent styling for select and input elements */
#district, #service-type, #from-date, #to-date, #num_of_passengers, #name, #type_of_vehicle, #vehicle-number, #mobile-number, #email, #reason, #address, #passenger-details {
    width: 100%; /* Set the width to 100% to match other input containers */
    height: 40px; /* Set the height to match other input containers */
    padding: 5px; /* Add some padding for spacing */
    border: 1px solid #ccc; /* Add a border for consistency */
    border-radius: 5px; /* Add rounded corners */
    font-size: 16px; /* Adjust the font size as needed */
    text-align: left; /* Set text alignment as needed */
}

/* If you want to match the font size and text alignment as well */
#district, #service-type, #from-date, #to-date {
    font-size: 16px; /* Adjust the font size as needed */
    text-align: left; /* Set text alignment as needed */
}

  
</style>
    <style>
        .grid-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .grid-item {
            flex-basis: calc(50% - 10px);
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s, transform 0.2s;
        }

        .grid-item1 {
            flex-basis: calc(100% - 10px);
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
            background-color: darkgreen;
        }

        .grid-item1 button:hover {
            background-color: darkgreen;
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
            margin: 1px;
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
            background-color: #212121;
            border-color: rgb(73, 73, 73);
        }

        .selected {
            background-color: #212121;
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
            width: 100%;
        }

        #aa {
            background-color: white;
            margin: 0%;
        }

        #subList {
            display: none;
            position: absolute;
        }
        
    </style>
 <style>
    .container-fluidx {
    box-shadow: 0px 0px 10px rgba(91, 84, 232, 0.2);
    margin-left: 8%;
    margin-right: 8%;
    background-color:white;
    
}
.form-sectionx {
    margin: 20px;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 10px;
  }

#row1x {
    
    margin-top: 1%;
    background-color: #2c5686;
    text-align: center;
}

.custom-image {
    display: inline-block;
    margin: 0 auto; /* Center the image horizontally */
    padding: 8px; /* Add padding to center vertically */
}
.form-section label {
    display: block;
    width: fit-content;
    margin-bottom: 5px;
  }

  /* Center align labels for checkboxes and radio buttons */
  .form-section label.radio-label,
  .form-section label.checkbox-label {
    text-align: center;
  }

  /* Style for the image preview */
  .image-preview {
    max-width: 100px;
    max-height: 100px;
    margin-top: 10px;
  }
  /* Add any custom CSS styles here */

  
  .center-align {
    text-align: center;
  }
  
  .form-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
  }
  
  /* Add styling for image preview */
  .image-preview {
    max-width: 100px;
    max-height: 100px;
    margin-top: 10px;
    display: none; /* Hide by default */
  }
  /* Add any custom CSS styles here */
.form-section {
    margin: 20px;
    margin-right: 2%;
    padding: 20px;
    border: 2px solid rgb(93, 89, 89);
    border-radius: 5px;
    background-color: #eaf1fb;
  }
  /* Apply consistent styling for select and input elements */
#district, #service-type, #from-date, #to-date {
    width: 90%; /* Set the width to 100% to match other input containers */
     /* Set the height to match other input containers */
    padding: 5px; /* Add some padding for spacing */
    border: 1px solid #ccc; /* Add a border for consistency */
    border-radius: 5px; /* Add rounded corners */
  }
  
  /* If you want to match the font size and text alignment as well */
  #district, #service-type, #from-date, #to-date {
    font-size: 16px; /* Adjust the font size as needed */
    text-align: left; /* Set text alignment as needed */
  }
  
  .center-align {
    text-align: center;
  }
  
  .form-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
  }
  
  /* Add styling for image preview */
  .image-preview {
    max-width: 100px;
    max-height: 100px;
    margin-top: 10px;
    display: none; /* Hide by default */
  }
  /* Style for the green button */
.green-button {
    background-color: #4CAF50; /* Green background color */
    color: #fff; /* Text color */
    padding: 10px 20px; /* Padding for the button */
    border: none; /* Remove button border */
    border-radius: 5px; /* Add rounded corners */
    cursor: pointer; /* Change cursor to pointer on hover */
    transition: background-color 0.3s; /* Smooth transition on hover */
  }
  
  /* Hover effect for the green button */
  .green-button:hover {
    background-color: #45a049; /* Darker green on hover */
  }
  
 </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 d-flex align-items-center" id="e2">Gateway ePass</div>
            <div class="col-8"></div>
            <div class="col-2 d-flex align-items-center">
                <button>Approved-list</button>
                <img src="./profile1.png" alt="Profile Image" class="img-fluid rounded-circle" style="width: 20px; height: 20px;">
            </div>
        </div>
    </div>
    <div id="container">
        <div id="left-column" class="col-2">
            <nav style="margin-top: 10%;">
                <ul>
                    <li class="selected"><a href="#">Registeration</a></li>
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
        <div id="right-column">
        
        <div class="container-fluidx" style="width: 84%;">
        <div class="rowx" id="row1x">
            <div class="col-12">
            <img src="../apply/t.png" alt="Centered Image" class="custom-image" style="width: 100px; border-radius: 50%;">
            </div>
        </div>
        <div class="rowx">
        <form action="../download/pdf1.php" method="post" enctype="multipart/form-data">
                <br>
                <h3 style="text-align: center;">Emergency Service Form</h3>
                <div class="form-section">
                    <div class="form-grid">
                        <div>
                            <label for="district">District</label>
                            <select id="district" name="district">
                                <option value="nagpur">Nagpur</option>
                                <option value="pune">Pune</option>
                                <!-- Add more district options -->
                            </select>
                        </div>
                        <div>
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name">
                        </div>
                        <div>
                            <label for="service-type">Type of Service</label>
                            <select id="service-type" name="service-type">
                                <option value="personal">Personal</option>
                                <option value="organization">Organization</option>
                            </select>
                        </div>
                        <div>
                            <label for="type_of_vehicle">Type of Vehicle:</label>
                            <select name="type_of_vehicle" id="type_of_vehicle">
                                <option value="car">Car</option>
                                <option value="bike">Bike</option>
                                <option value="bus">Bus</option>
                            </select>
                        </div>
                        <div>
                            <label for="vehicle-number">Vehicle Number</label>
                            <input type="text" id="vehicle-number" name="vehicle-number">
                        </div>
                        <div>
                            <label for="mobile-number">Mobile Number</label>
                            <input type="text" id="mobile-number" name="mobile-number">
                        </div>
                        <div>
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email">
                        </div>
                        <div>
                            <label for="from-date">From Date</label>
                            <input type="date" id="from-date" name="from-date">
                        </div>
                        <div>
                            <label for="to-date">To Date</label>
                            <input type="date" id="to-date" name="to-date">
                        </div>
                        
                        <div>
                            <label for="reason">purpose of visit</label>
                            <textarea id="reason" name="reason"></textarea>
                        </div>
                        <div>
                            <label for="address">Address</label>
                            <textarea id="address" name="address"></textarea>
                        </div>
                        <div>
                            <label for="num_of_passengers">Number of Passengers:</label>
                            <select name="num_of_passengers" id="num_of_passengers">
                                <option value="0">0</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                        <div>
                            <label for="passenger details">passenger details</label>
                            <textarea id="passenger details" name="passenger details"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="form-section">
                    <h2>Attachments</h2>
                    <div class="form-grid">
                        <div>
                            <label>Webcam</label>
                            <input type="text" disabled value="Disabled">
                        </div>
                        <div>
                            <label for="passport-photo">Attach Passport Size Photo</label>
                            <input type="file" id="passport-photo" name="passport-photo" onchange="previewImage(this, 'passport-preview')">
                            <img id="passport-preview" src="" alt="Preview" class="image-preview">
                        </div>
                        <div>
                            <label for="medical-report">Lisence</label>
                            <input type="file" id="medical-report" name="medical-report" onchange="previewImage(this, 'medical-report-preview')">
                            <img id="medical-report-preview" src="" alt="Preview" class="image-preview">
                        </div>
                    </div>
                </div>
                <div class="center-align">
                    <button class="green-button" type="submit">Apply</button>
                </div>
                <input type="hidden" id="token" name="token" value="">
                <br><br><br>
            </form>
        </div>
    </div>
        
        
        </div>
    </div>
        </div>
                    </div>
                    <script>
                        function toggleOptions(id) {
                            const options = document.getElementById(id);
                            options.style.display = options.style.display === 'block' ? 'none' : 'block';
                        }
                    </script>
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
   
                </div>
            </div>
            <br> <br><br> <br><br> <br>
        </div>
        <br> <br><br> <br><br> <br>
    </div>
    <script>
        // Function to generate a random token
        function generateToken() {
            const alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            let token = '';
            // First three characters as alphabets
            for (let i = 0; i < 3; i++) {
                token += alphabet[Math.floor(Math.random() * alphabet.length)];
            }
            // Rest as numbers (14 digits)
            for (let i = 0; i < 14; i++) {
                token += Math.floor(Math.random() * 10);
            }
            return token;
        }

        // Function to display image preview
        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.style.display = 'none';
            }
        }

        // Set the generated token to the hidden input field
        const form = document.querySelector('form');
        const tokenInput = document.getElementById('token');
        tokenInput.value = generateToken();
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
// Close the database connection
mysqli_close($conn);
?>
