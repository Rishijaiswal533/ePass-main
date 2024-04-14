<!DOCTYPE html>
<html>
<head>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
        }

        h1 {
            text-align: center;
        }

        .table-container {
            max-width: 100%;
            margin: 20px auto;
            overflow-x: auto;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            background-color: white;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            text-align: center;
            border: 1px solid #ddd;
            width: 50px;
            height: 50px;
            max-width: 100%; /* Ensure content doesn't overflow the cell */
            max-height: 100%; /* Ensure content doesn't overflow the cell */
        }

        th {
            background-color: #2c5686;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .view-button {
            background-color: green;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        .view-button:hover {
            background-color: darkgreen;
        }

        /* Add scrolling for table cells */
        .scrollable {
            overflow: auto;
        }
    </style>
  
</head>
<body>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
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

    // Define the tables to fetch data from
    $tables = ['y1', 'y2', 'emg', 'n2'];

    // Define headings based on table names
    $tableHeadings = [
        'y1' => 'For out of Maharashtra less than 5 passengers',
        'y2' => 'For out of Maharashtra more than 5 passengers',
        'emg' => 'Emergency pass within Maharashtra',
        'n2' => 'Maharashtra only'
    ];

    // Fetch data from each table and display it in separate tables with appropriate headings
    foreach ($tables as $table) {
        echo "<h1>" . $tableHeadings[$table] . "</h1>";
        echo "<table style='width: 100%;'>"; // Set table width to 100%
        
        // Query the database to retrieve all data from each table
        $sql = "SELECT * FROM $table";
        $results = mysqli_query($conn, $sql);

        if ($results) {
            // Create table headers based on column names from the first row of data
            if ($row = mysqli_fetch_assoc($results)) {
                echo "<tr>";
                foreach (array_keys($row) as $column) {
                    echo "<th>$column</th>";
                }
                echo "<th>Action</th>"; // Add an extra column for the "View" button
                echo "</tr>";
                
                // Display the first row of data
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . $value . "</td>";
                }
                // Pass the token as a query parameter to view.php when the "View" button is clicked
                echo "<td><button class='view-button' onclick='viewToken(\"{$row['token']}\")'>View</button></td>";
                echo "</tr>";
            }

            // Display the remaining rows of data
            while ($row = mysqli_fetch_assoc($results)) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . $value . "</td>";
                }
                // Pass the token as a query parameter to view.php when the "View" button is clicked
                echo "<td><button class='view-button' onclick='viewToken(\"{$row['token']}\")'>View</button></td>";
                echo "</tr>";
            }
            
            mysqli_free_result($results); // Free the result set
        } else {
            echo "Error in query for $table: " . mysqli_error($conn);
        }

        echo "</table>";
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</body>
<script>
    function viewToken(token) {
        // Redirect to view.php with the token as a query parameter
        window.location.href = "view.php?token=" + token;
    }
</script>
</html>
