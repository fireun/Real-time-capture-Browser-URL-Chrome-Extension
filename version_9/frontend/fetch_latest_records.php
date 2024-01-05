<?php
//database connection
include('../db_connection.php');

if(isset($_POST['action']) && $_POST['action'] === 'getLatestSpiderScanTotal'){

    $getSpirderTotal = "SELECT MAX(`Scan_ID`) AS `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, MAX(`date_time`) AS `date_time`
            FROM `scanning_result`
            WHERE 1
            GROUP BY `domain_name`
            HAVING TIMESTAMPDIFF(MINUTE, MIN(`date_time`), MAX(`date_time`)) <= 5
            ORDER BY `date_time` DESC";

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

 
    $getDetectUrlsTable = "SELECT MAX(`Scan_ID`) AS `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, MAX(`date_time`) AS `date_time`
            FROM `scanning_result`
            WHERE 1
            GROUP BY `domain_name`
            HAVING TIMESTAMPDIFF(MINUTE, MIN(`date_time`), MAX(`date_time`)) <= 5
            ORDER BY `date_time` DESC";
    $resultofgetDetectUrlsTable = $mysqli->query($getDetectUrlsTable);
    if ($resultofgetDetectUrlsTable->num_rows > 0) {
        while ($row = $resultofgetDetectUrlsTable->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["domain_name"] . "</td>
                    <td>" . $row["Scan_ID"] . "</td>
                    <td>" . $row["zap_scan_id"] . "</td>
                    <td>" . $row["url"] . "</td>
                    <td>" . $row["date_time"] . "</td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No records found</td></tr>";
    }
}//end get lastest domain list


$mysqli->close();

?>
