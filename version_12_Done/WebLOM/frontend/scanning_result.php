<?php
// Include database connection and sanitation functions
include('../db_connection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to sanitize user inputs
function sanitizeInput($input) {
    return mysqli_real_escape_string($GLOBALS['mysqli'], $input);
}


if (isset($_GET['scanID'])) {
    // echo $_GET['scanID'];
    // Get the Scan_ID from the query string
    $selectedScanID = sanitizeInput($_GET['scanID']);

    // First Query
    $spirderScansql1 = "SELECT `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, `date_time`
            FROM `scanning_result`
            WHERE `Scan_ID` = " . $selectedScanID;
    $resultofspirderScansql1 = mysqli_query($mysqli, $spirderScansql1);

    if (!$resultofspirderScansql1) {
        die('Error in the query: ' . mysqli_error($mysqli));
    }

    '<h2>Results for Scan ID: ' . $selectedScanID . '</h2>';

    if ($row = mysqli_fetch_assoc($resultofspirderScansql1)) {
        $selectedDomainName = $row['domain_name'];
        $selectedDateTime = $row['date_time'];
    }
}
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>WebLOM</title>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">  <!--  fixed table content -->
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    </head>
    <body class="sb-nav-fixed">
        <!-- header bar -->
        <?php require 'header.php';?>
        <!-- End of header bar -->

         <!-- left bar -->
         <?php require 'leftbar.php';?>
         <!-- End of left bar -->
         
        <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">
                        <h1 class="mt-4">Security Assessment Report</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="tables.php">All Result</a></li>
                            <li class="breadcrumb-item active"><?php echo $selectedDomainName; ?> </li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h2>Scanning Result of domain: <?php echo $selectedDomainName; ?> </h2>
                                <h3>Detect Date: <?php echo $selectedDateTime;?> </h3>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Spider Scanning
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="spiderTable" class="display responsive nowrap dataTable">
                                    <thead>
                                        <tr>
                                                <th>Domain</th>
                                                <th>ScanID</th>
                                                <th>ZapScanID</th>
                                                <th>URLs</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Domain</th>
                                                <th>ScanID</th>
                                                <th>ZapScanID</th>
                                                <th>URLs</th>
                                                <th>Date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>

                                            <?php
                                                if (isset($_GET['scanID'])) {
                                                    // echo $_GET['scanID'];
                                                    // Get the Scan_ID from the query string
                                                    $selectedScanID = sanitizeInput($_GET['scanID']);
                                                
                                                    // First Query
                                                    $spirderScansql1 = "SELECT `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, `date_time`
                                                            FROM `scanning_result`
                                                            WHERE `Scan_ID` = " . $selectedScanID;
                                                    $resultofspirderScansql1 = mysqli_query($mysqli, $spirderScansql1);
                                                
                                                    if (!$resultofspirderScansql1) {
                                                        die('Error in the query: ' . mysqli_error($mysqli));
                                                    }
                                                
                                                    '<h2>Results for Scan ID: ' . $selectedScanID . '</h2>';
                                                
                                                    if ($row = mysqli_fetch_assoc($resultofspirderScansql1)) {
                                                        $selectedDomainName = $row['domain_name'];
                                                        $selectedDateTime = $row['date_time'];
                                                    
                                                        // Second Query
                                                        $spirderScansql2 = "SELECT `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, `date_time`
                                                                FROM `scanning_result`
                                                                WHERE `domain_name` = '" . sanitizeInput($selectedDomainName) . "'
                                                                AND TIMESTAMPDIFF(MINUTE, `date_time`, '" . sanitizeInput($selectedDateTime) . "') <= 5
                                                                ORDER BY `date_time` DESC";
                                                    
                                                        $resultofspirderScansql2 = mysqli_query($mysqli, $spirderScansql2);
                                                    
                                                        if (!$resultofspirderScansql2) {
                                                            die('Error in the query: ' . mysqli_error($mysqli));
                                                        }
                                                    
                                                        // Output the results in a table
                                                        // echo '<table border="1">';
                                                        // echo '<tr><th>Scan ID</th><th>ZAP Scan ID</th><th>Domain Name</th><th>URL</th><th>Date Time</th></tr>';
                                                        
                                                        // // Check the number of rows
                                                        // $numRows1 = mysqli_num_rows($resultofspirderScansql2);

                                                        // // Output the results in a table
                                                        // echo '<p>Number of rows: ' . $numRows1 . '</p>';
                        
                                                        while ($row2 = mysqli_fetch_assoc($resultofspirderScansql2)) {
                                                            echo '<tr>';
                                                            echo '<td>' . $row2['domain_name'] . '</td>';
                                                            echo '<td>' . $row2['Scan_ID'] . '</td>';
                                                            echo '<td>' . $row2['zap_scan_id'] . '</td>';
                                                            echo '<td>' . $row2['url'] . '</td>';
                                                            echo '<td>' . $row2['date_time'] . '</td>';
                                                            echo '</tr>';
                                                        }
                                                    
                                                        // echo '</table>';
                                                    

                                                    } else {
                                                        echo '<p>No results found for Scan ID: ' . $selectedScanID . '</p>';
                                                    }
                                                } else {
                                                    echo '<p>No Scan ID provided in the query string.</p>';
                                                }
                                            
                                            ?>  
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Passive Scanning
                            </div>
                            <div class="card-body">
                                
                                
                                <div class="row">
                                    <div class="col-xs-12">
                                    <table id="passiveTable" class="display responsive nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Domain</th>
                                                <th>Scan ID</th>
                                                <th>Result ID</th>
                                                <th>Alert Name</th>
                                                <th>Alert Risk</th>
                                                <th>Alert Ref</th>
                                                <th>Evidence</th>
                                                <th>Url</th>
                                                <th>date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>NO</th>
                                                <th>Domain</th>
                                                <th>Scan ID</th>
                                                <th>Result ID</th>
                                                <th>Alert Name</th>
                                                <th>Alert Risk</th>
                                                <th>Alert Ref</th>
                                                <th>Evidence</th>
                                                <th>Url</th>
                                                <th>date</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                           <?php

                                                if (isset($_GET['scanID'])) {

                                                    if ($selectedDomainName) {
                                                        // Retrieve Passive Scan data within a 10-minute window
                                                        $passiveScanSql = "SELECT
                                                                            ps.`passive_domain_name`,
                                                                            ps.`passive_zap_scan_ID`,
                                                                            ps.`passive_result_alert_name`,
                                                                            ps.`passive_result_alert_Ref`,
                                                                            ps.`passive_result_evidence`,
                                                                            ps.`passive_result_id`,
                                                                            ps.`passive_result_URL`,
                                                                            ai.`alert_ID`,
                                                                            MAX(ps.`passive_dataTime`) AS `passive_dataTime`,
                                                                            MAX(CASE WHEN ai.`alert_risk` IN ('Medium', 'High') THEN ai.`alert_risk` END) AS `selected_alert_risk`
                                                                        FROM
                                                                            `passive_scan` ps
                                                                        LEFT JOIN
                                                                            `alert_info` ai ON ps.`passive_result_alert_Ref` = ai.`alert_Ref`
                                                                        WHERE
                                                                            ps.`passive_domain_name` = '". $selectedDomainName . "'
                                                                            AND TIMESTAMPDIFF(MINUTE, ps.`passive_dataTime`, '" . $selectedDateTime . "') <= 10
                                                                        GROUP BY
                                                                            ps.`passive_domain_name`,
                                                                            ps.`passive_zap_scan_ID`,
                                                                            ps.`passive_result_alert_name`,
                                                                            ps.`passive_result_alert_Ref`,
                                                                            ps.`passive_result_URL`  
                                                                        ORDER BY `ps`.`passive_result_alert_name` ASC";
                                                                                                       
                                                    


                                                        $passiveScanResult = $mysqli->query($passiveScanSql);

                                                        // Check the number of rows
                                                        //$passiveRow = mysqli_num_rows($passiveScanResult);
                                                        $no = 0;

                                                        // // Output the results in a table
                                                        // echo '<p>Number of rows: ' . $numRows . '</p>';
                                                        if ($passiveScanResult->num_rows > 0) {
                                                            while ($passiveRow = $passiveScanResult->fetch_assoc()) {
                                                                $escapedHtmlData = htmlspecialchars($passiveRow['passive_result_evidence'], ENT_QUOTES, 'UTF-8'); //transfer to text only

                                                                echo '<tr>';
                                                                echo '<td>' . $no . '</td>';
                                                                echo '<td>' . $passiveRow['passive_domain_name'] . '</td>';
                                                                echo '<td>' . $passiveRow['passive_zap_scan_ID'] . '</td>';
                                                                echo '<td>' . $passiveRow['passive_result_id'] . '</td>';
                                                                echo '<td> <a href="alertDetails.php?AID='. $passiveRow['alert_ID'] .'">' . $passiveRow['passive_result_alert_name'] . '</a></td>';
                                                                echo '<td>' . ($passiveRow['selected_alert_risk'] ?? 'N/A') . '</td>'; // Display 'N/A' if empty
                                                                echo '<td>' . $passiveRow['passive_result_alert_Ref'] . '</td>';
                                                                echo '<td><p>' . $escapedHtmlData . '</p></td>'; // Display 'No evidence' if empty
                                                                echo '<td>' . $passiveRow['passive_result_URL'] . '</td>';
                                                                echo '<td>' . $passiveRow['passive_dataTime'] . '</td>';
                                                                echo '</tr>';
                                                                $no ++;
                                                            }
                                                        }else {
                                                            echo '<p>No results found for Scan ID: ' . $selectedScanID . '</p>';
                                                        }
                                                    
                                                    } else {
                                                        echo '<p>No results found for Scan ID: ' . $selectedScanID . '</p>';
                                                    }
                                                } else {
                                                    echo '<p>No Scan ID provided in the query string.</p>';
                                                }
                                                ?> 
                                        </tbody>
                                    </table>
                                    </div>
                                </div>

                            </div>
                        </div>


                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Active Scanning
                            </div>
                            <div class="card-body">
                                <table id="activeTable" class="display responsive nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Domain</th>
                                                <th>Scan ID</th>
                                                <th>Result ID</th>
                                                <th>Alert Name</th>
                                                <th>Alert Risk</th>
                                                <th>Alert Ref</th>
                                                <th>Evidence</th>
                                                <th>Url</th>
                                                <th>date</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>NO</th>
                                                <th>Domain</th>
                                                <th>Scan ID</th>
                                                <th>Result ID</th>
                                                <th>Alert Name</th>
                                                <th>Alert Risk</th>
                                                <th>Alert Ref</th>
                                                <th>Evidence</th>
                                                <th>Url</th>
                                                <th>date</th>
                                            </tr>
                                        </tfoot>
                                    <tbody>
                                        <?php

                                            if (isset($_GET['scanID'])) {

                                                if ($selectedDomainName) {
                                                    // Retrieve Active Scan data within a 10-minute window
                                                    $activeScanSql = "SELECT
                                                                            active_scan.`active_domain_name`,
                                                                            active_scan.`active_zap_scan_ID`,
                                                                            active_scan.`active_result_alert_name`,
                                                                            active_scan.`active_result_alert_Ref`,
                                                                            active_scan.`active_result_evidence`,
                                                                            active_scan.`active_result_id`,
                                                                            active_scan.`active_result_URL`,
                                                                            ai.`alert_ID`,
                                                                            MAX(active_scan.`active_dataTime`) AS `active_dataTime`,
                                                                            MAX(CASE WHEN ai.`alert_risk` IN ('Medium', 'High') THEN ai.`alert_risk` END) AS `selected_alert_risk`
                                                                        FROM
                                                                            `active_scan` 
                                                                        LEFT JOIN 
                                                                            `alert_info` ai ON active_scan.`active_result_alert_Ref` = ai.`alert_Ref`
                                                                        WHERE
                                                                            active_scan.`active_domain_name` = '". $selectedDomainName . "'
                                                                            AND TIMESTAMPDIFF(MINUTE, active_scan.`active_dataTime`, '" . $selectedDateTime . "') <= 10
                                                                        GROUP BY
                                                                            active_scan.`active_domain_name`,
                                                                            active_scan.`active_zap_scan_ID`,
                                                                            active_scan.`active_result_alert_name`,
                                                                            active_scan.`active_result_alert_Ref`,
                                                                            active_scan.`active_result_URL`  
                                                                        ORDER BY `active_scan`.`active_result_id` ASC";
                                                
                                                                                                
                                                
                                                    $activeScanResult = $mysqli->query($activeScanSql);

                                                    // Check the number of rows
                                                    //$passiveRow = mysqli_num_rows($passiveScanResult);
                                                    $no = 0;
                                                    // // Output the results in a table
                                                    // echo '<p>Number of rows: ' . $numRows . '</p>';
                                                    if ($activeScanResult->num_rows > 0) {
                                                        while ($activeRow = $activeScanResult->fetch_assoc()) {
                                                            $escapedHtmlDataofactiveRow = htmlspecialchars($activeRow['active_result_evidence'], ENT_QUOTES, 'UTF-8'); //transfer to text only
                                                            //echo 'alert_id' . $activeRow['alert_ID'];
                                                            echo '<tr>';
                                                            echo '<td>' . $no . '</td>';
                                                            echo '<td>' . $activeRow['active_domain_name'] . '</td>';
                                                            echo '<td>' . $activeRow['active_zap_scan_ID'] . '</td>';
                                                            echo '<td>' . $activeRow['active_result_id'] . '</td>';
                                                            echo '<td> <a href="alertDetails.php?AID='. $activeRow['alert_ID'] .'">' . $activeRow['active_result_alert_name'] . '</a></td>';
                                                            echo '<td>' . ($activeRow['selected_alert_risk'] ?? 'N/A') . '</td>'; // Display 'N/A' if empty
                                                            echo '<td>' . $activeRow['active_result_alert_Ref'] . '</td>';
                                                            echo '<td><p>' . $escapedHtmlDataofactiveRow . '</p></td>'; // Display 'No evidence' if empty
                                                            echo '<td>' . $activeRow['active_result_URL'] . '</td>';
                                                            echo '<td>' . $activeRow['active_dataTime'] . '</td>';
                                                            echo '</tr>';
                                                            $no ++;
                                                        }
                                                    }else {
                                                        echo '<p>No results found for Scan ID: ' . $selectedScanID . '</p>';
                                                    }
                                                
                                                } else {
                                                    echo '<p>No results found for Scan ID: ' . $selectedScanID . '</p>';
                                                }
                                            } else {
                                                echo '<p>No Scan ID provided in the query string.</p>';
                                            }
                                            ?> 
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; WebLOM 2023 Develop by: Woon Xun  </div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>

        </div>


    <!-- JavaScript Files -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> <!-- fix table content -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <script>

        $(document).ready(function() {
            $('#spiderTable').DataTable({
                "processing": true,
                "scrollCollapse": true,
                "paging": true,     // Disable pagination for vertical scrolling
                
            });

            $('#passiveTable, #activeTable').DataTable({
                "processing": true,
                "scrollY": "400px", // Adjust the height as needed
                "scrollX": true,    // Enable horizontal scrolling
                "scrollCollapse": true,
                "paging": true,     // Disable pagination for vertical scrolling
    
            });

          
        });
    </script>

    </body>
    
</html>
