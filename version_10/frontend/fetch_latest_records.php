<?php
//database connection
include('../db_connection.php');

if(isset($_POST['action']) && $_POST['action'] === 'getLatestSpiderScanTotal'){

    $getSpirderTotal = "SELECT 
                            MAX(`Scan_ID`) AS `Scan_ID`, 
                            `zap_scan_id`, 
                            `domain_name`, 
                            `url`, 
                            MAX(`date_time`) AS `date_time` 
                        FROM 
                            `scanning_result` 
                        WHERE 
                            1 
                        GROUP BY 
                            `domain_name`, 
                            FLOOR(UNIX_TIMESTAMP(`date_time`) / (5 * 60))  -- Group by 5-minute intervals
                        HAVING 
                            COUNT(*) > 1  -- Filter groups with more than one record
                        ORDER BY 
                            `date_time` DESC";

    $resultofgetSpirderTotal = $mysqli->query($getSpirderTotal);

    if ($resultofgetSpirderTotal->num_rows > 0) {
        
        $rowCount = $resultofgetSpirderTotal->num_rows;
        echo ' - ' . $rowCount;
        
    } else {
        $rowCount = 0;
        echo '0';
    }

}//end get lastest spirder scan total


if(isset($_POST['action']) && $_POST['action'] === 'getLatestDomainList'){

 
    $getDetectUrlsTable = "SELECT 
                            MAX(`Scan_ID`) AS `Scan_ID`, 
                            `zap_scan_id`, 
                            `domain_name`, 
                            `url`, 
                            MAX(`date_time`) AS `date_time` 
                        FROM 
                            `scanning_result` 
                        WHERE 
                            1 
                        GROUP BY 
                            `domain_name`, 
                            FLOOR(UNIX_TIMESTAMP(`date_time`) / (5 * 60))  -- Group by 5-minute intervals
                        HAVING 
                            COUNT(*) > 1  -- Filter groups with more than one record
                        ORDER BY 
                            `date_time` DESC";
                            
    $resultofgetDetectUrlsTable = $mysqli->query($getDetectUrlsTable);
    if ($resultofgetDetectUrlsTable->num_rows > 0) {
        while ($row = $resultofgetDetectUrlsTable->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["domain_name"] . "</td>
                    <td>" . $row['Scan_ID'] . " </td>
                    <td>" . $row["zap_scan_id"] . "</td>
                    <td>" . $row["url"] . "</td>
                    <td>" . $row["date_time"] . "</td>
                    <td><button type='button' class='btn btn-primary' onclick='fetchScanData(" . $row['Scan_ID'] . ")'>View</button></td>
                </tr>";
        }        
    } else {
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
}//end get lastest domain list


// // Function to generate hyperlinks
// function generateHyperlink($row) {
//     $scanID = $row["Scan_ID"];
//     $url = "scanning_result.php?scan_id=$scanID";
//     return "<a href='$url' target='_blank'>$scanID</a>";
// }









if(isset($_GET['scan_id'])) {
    
    // Function to sanitize user inputs
    function sanitizeInput($input) {
        return mysqli_real_escape_string($GLOBALS['mysqli'], $input);
    }

    // Get the Scan_ID from the AJAX request
    $selectedScanID = sanitizeInput($_POST['scanID']);

    // First Query
    $sql1 = "SELECT `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, `date_time`
            FROM `scanning_result`
            WHERE `Scan_ID` = " . $selectedScanID;
    $result1 = mysqli_query($mysqli, $sql1);

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

        // Output the results
        echo '<h2>Results for Scan ID: ' . $selectedScanID . '</h2>';
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
    }

}

$mysqli->close();

?>
