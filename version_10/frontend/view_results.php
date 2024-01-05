<?php
// Include database connection and sanitation functions
include('../db_connection.php');

// Function to sanitize user inputs
function sanitizeInput($input) {
    return mysqli_real_escape_string($GLOBALS['mysqli'], $input);
}

if (isset($_GET['scanID'])) {
    // echo $_GET['scanID'];
    // Get the Scan_ID from the query string
    $selectedScanID = sanitizeInput($_GET['scanID']);

    // First Query
    echo $sql1 = "SELECT `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, `date_time`
            FROM `scanning_result`
            WHERE `Scan_ID` = " . $selectedScanID;
    $result1 = mysqli_query($mysqli, $sql1);

    if (!$result1) {
        die('Error in the query: ' . mysqli_error($mysqli));
    }

    echo '<h2>Results for Scan ID: ' . $selectedScanID . '</h2>';

    if ($row = mysqli_fetch_assoc($result1)) {
        $selectedDomainName = $row['domain_name'];
        $selectedDateTime = $row['date_time'];

        // Second Query
        $sql2 = "SELECT `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, `date_time`
                FROM `scanning_result`
                WHERE `domain_name` = '" . sanitizeInput($selectedDomainName) . "'
                AND TIMESTAMPDIFF(MINUTE, `date_time`, '" . sanitizeInput($selectedDateTime) . "') <= 5
                ORDER BY `date_time` DESC";

        $result2 = mysqli_query($mysqli, $sql2);

        if (!$result2) {
            die('Error in the query: ' . mysqli_error($mysqli));
        }

        // Output the results in a table
        echo '<table border="1">';
        echo '<tr><th>Scan ID</th><th>ZAP Scan ID</th><th>Domain Name</th><th>URL</th><th>Date Time</th></tr>';

        while ($row2 = mysqli_fetch_assoc($result2)) {
            echo '<tr>';
            echo '<td>' . $row2['Scan_ID'] . '</td>';
            echo '<td>' . $row2['zap_scan_id'] . '</td>';
            echo '<td>' . $row2['domain_name'] . '</td>';
            echo '<td>' . $row2['url'] . '</td>';
            echo '<td>' . $row2['date_time'] . '</td>';
            echo '</tr>';
        }

        echo '</table>';

        
    } else {
        echo '<p>No results found for Scan ID: ' . $selectedScanID . '</p>';
    }
} else {
    echo '<p>No Scan ID provided in the query string.</p>';
}

$mysqli->close();
?>
