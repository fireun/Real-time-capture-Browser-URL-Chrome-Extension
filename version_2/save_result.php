<?php
// Retrieve JSON data from the Flask app
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Assuming $data contains the spider results and scan_id
$spider_results = $data['spider_results'];
$scan_id = $data['scan_id'];

// Connect to MySQL
$mysqli = new mysqli("localhost", "root", "", "test_fyp");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Insert spider results into the database
foreach ($spider_results as $result) {
    $sql = "INSERT INTO scanning_result (zap_scan_id, url) VALUES ('$scan_id', '$result')";
    if ($mysqli->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    }
}

// Close the MySQL connection
$mysqli->close();
?>
