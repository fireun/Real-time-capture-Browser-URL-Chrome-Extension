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
    // $selectedScanID = sanitizeInput($_GET['scanID']);

    // // First Query
    // echo $sql1 = "SELECT `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, `date_time`
    //         FROM `scanning_result`
    //         WHERE `Scan_ID` = " . $selectedScanID;
    // $result1 = mysqli_query($mysqli, $sql1);

    // if (!$result1) {
    //     die('Error in the query: ' . mysqli_error($mysqli));
    // }

    // echo '<h2>Results for Scan ID: ' . $selectedScanID . '</h2>';

    // if ($row = mysqli_fetch_assoc($result1)) {
    //     $selectedDomainName = $row['domain_name'];
    //     $selectedDateTime = $row['date_time'];

    //     // Second Query
    //     $sql2 = "SELECT `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, `date_time`
    //             FROM `scanning_result`
    //             WHERE `domain_name` = '" . sanitizeInput($selectedDomainName) . "'
    //             AND TIMESTAMPDIFF(MINUTE, `date_time`, '" . sanitizeInput($selectedDateTime) . "') <= 5
    //             ORDER BY `date_time` DESC";

    //     $result2 = mysqli_query($mysqli, $sql2);

    //     if (!$result2) {
    //         die('Error in the query: ' . mysqli_error($mysqli));
    //     }

    //     // Output the results in a table
    //     echo '<table border="1">';
    //     echo '<tr><th>Scan ID</th><th>ZAP Scan ID</th><th>Domain Name</th><th>URL</th><th>Date Time</th></tr>';

    //     while ($row2 = mysqli_fetch_assoc($result2)) {
    //         echo '<tr>';
    //         echo '<td>' . $row2['Scan_ID'] . '</td>';
    //         echo '<td>' . $row2['zap_scan_id'] . '</td>';
    //         echo '<td>' . $row2['domain_name'] . '</td>';
    //         echo '<td>' . $row2['url'] . '</td>';
    //         echo '<td>' . $row2['date_time'] . '</td>';
    //         echo '</tr>';
    //     }

    //     echo '</table>';

        
    // } else {
    //     echo '<p>No results found for Scan ID: ' . $selectedScanID . '</p>';
    // }
} else {
    echo '<p>No Scan ID provided in the query string.</p>';
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
                        <h1 class="mt-4">Scanning Result</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tables</li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                DataTables is a third party plugin that is used to generate the demo table below. For more information about DataTables, please visit the
                                <a target="_blank" href="https://datatables.net/">official DataTables documentation</a>
                                .
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Spider Scanning
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="spiderTable" class="display responsive table-responsive">
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
                                                        
                                                        // Check the number of rows
                                                        $numRows1 = mysqli_num_rows($resultofspirderScansql2);

                                                        // Output the results in a table
                                                        echo '<p>Number of rows: ' . $numRows1 . '</p>';
                        
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
                                    <table id="passiveTable" class="display">
                                        <thead>
                                            <tr>
                                                <th>Domain</th>
                                                <th>Scan ID</th>
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
                                                <th>Domain</th>
                                                <th>Scan ID</th>
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
                                                    // Get the Scan_ID from the query string
                                                    $selectedScanID = sanitizeInput($_GET['scanID']);

                                                    // Retrieve Spider Scan data
                                                    $spiderScanSql = "SELECT `Scan_ID`, `zap_scan_id`, `domain_name`, `url`, `date_time`
                                                                    FROM `scanning_result`
                                                                    WHERE `Scan_ID` = " . $selectedScanID;

                                                    $spiderScanResult = mysqli_query($mysqli, $spiderScanSql);

                                                    if (!$spiderScanResult) {
                                                        die('Error in the query: ' . mysqli_error($mysqli));
                                                    }

                                                    if ($spiderRow = mysqli_fetch_assoc($spiderScanResult)) {
                                                        $selectedDomainName = $spiderRow['domain_name'];
                                                        $selectedDateTime = $spiderRow['date_time'];

                                                        // Retrieve Passive Scan data within a 10-minute window
                                                        $passiveScanSql = "SELECT DISTINCT
                                                                            ps.`passive_domain_name`,
                                                                            ps.`passive_result_alert_name`,
                                                                            ps.`passive_result_alert_Ref`,
                                                                            ps.`passive_result_evidence`,
                                                                            ps.`passive_result_id`,
                                                                            ps.`passive_result_URL`,
                                                                            MAX(ps.`passive_dataTime`) AS `passive_dataTime`,
                                                                            ai.`alert_ID`,
                                                                            ai.`alert_Name`,
                                                                            ai.`alert_Ref`,
                                                                            ai.`alert_attack`,
                                                                            ai.`alert_confidence`,
                                                                            ai.`alert_cweid`,
                                                                            ai.`alert_descriptions`,
                                                                            ai.`alert_inputVector`,
                                                                            ai.`alert_messageId`,
                                                                            ai.`alert_method`,
                                                                            ai.`alert_other`,
                                                                            ai.`alert_param`,
                                                                            ai.`alert_pluginId`,
                                                                            ai.`alert_risk`,
                                                                            ai.`alert_solution`,
                                                                            ai.`alert_sourceid`,
                                                                            ai.`alert_wascid`,
                                                                            ai.`alert_dateTime`
                                                                        FROM `passive_scan` ps
                                                                        LEFT JOIN `alert_info` ai ON ps.`passive_result_alert_Ref` = ai.`alert_Ref`
                                                                        WHERE ps.`passive_domain_name` = '" . sanitizeInput($selectedDomainName) . "'
                                                                        AND TIMESTAMPDIFF(MINUTE, ps.`passive_dataTime`, '" . sanitizeInput($selectedDateTime) . "') <= 10
                                                                        GROUP BY
                                                                            ps.`passive_domain_name`,
                                                                            ps.`passive_result_alert_name`,
                                                                            ps.`passive_result_alert_Ref`,
                                                                            ps.`passive_result_evidence`,
                                                                            ps.`passive_result_id`,
                                                                            ps.`passive_result_URL`,
                                                                            ai.`alert_ID`,
                                                                            ai.`alert_Name`,
                                                                            ai.`alert_Ref`,
                                                                            ai.`alert_attack`,
                                                                            ai.`alert_confidence`,
                                                                            ai.`alert_cweid`,
                                                                            ai.`alert_descriptions`,
                                                                            ai.`alert_inputVector`,
                                                                            ai.`alert_messageId`,
                                                                            ai.`alert_method`,
                                                                            ai.`alert_other`,
                                                                            ai.`alert_param`,
                                                                            ai.`alert_pluginId`,
                                                                            ai.`alert_risk`,
                                                                            ai.`alert_solution`,
                                                                            ai.`alert_sourceid`,
                                                                            ai.`alert_wascid`,
                                                                            ai.`alert_dateTime`
                                                                        ORDER BY MAX(ps.`passive_dataTime`) DESC";


                                                        $passiveScanResult = mysqli_query($mysqli, $passiveScanSql);

                                                        if (!$passiveScanResult) {
                                                            die('Error in the query: ' . mysqli_error($mysqli));
                                                        }

                                                        // Check the number of rows
                                                        $numRows = mysqli_num_rows($passiveScanResult);

                                                        // Output the results in a table
                                                        echo '<p>Number of rows: ' . $numRows . '</p>';

                                                        while ($passiveRow = mysqli_fetch_assoc($passiveScanResult)) {
                                                            echo '<tr>';
                                                            echo '<td>' . $passiveRow['passive_domain_name'] . '</td>';
                                                            echo '<td>' . $passiveRow['passive_zap_scan_ID'] . '</td>';
                                                            echo '<td>' . $passiveRow['passive_result_alert_name'] . '</td>';
                                                            echo '<td>' . $passiveRow['alert_risk'] . '</td>';
                                                            echo '<td>' . $passiveRow['passive_result_alert_Ref'] . '</td>';
                                                            echo '<td>' . $passiveRow['passive_result_evidence'] . '</td>';
                                                            echo '<td>' . $passiveRow['passive_result_URL'] . '</td>';
                                                            echo '<td>' . $passiveRow['passive_dataTime'] . '</td>';
                                                            echo '</tr>';
                                                        }

                                                        echo '</table>';
                                                    } else {
                                                        echo '<p>No results found for Scan ID: ' . $selectedScanID . '</p>';
                                                    }
                                                } else {
                                                    echo '<p>No Scan ID provided in the query string.</p>';
                                                }
                                                ?>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr>
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
                                <table id="activeTable" class="display">
                                    <thead>
                                        <tr>
                                            <th>URLs</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Position</th>
                                            <th>Office</th>
                                            <th>Age</th>
                                            <th>Start date</th>
                                            <th>Salary</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>Tiger Nixon</td>
                                            <td>System Architect</td>
                                            <td>Edinburgh</td>
                                            <td>61</td>
                                            <td>2011/04/25</td>
                                            <td>$320,800</td>
                                        </tr>
                                        <tr>
                                            <td>Michael Bruce</td>
                                            <td>Javascript Developer</td>
                                            <td>Singapore</td>
                                            <td>29</td>
                                            <td>2011/06/27</td>
                                            <td>$183,000</td>
                                        </tr>
                                        <tr>
                                            <td>Donna Snider</td>
                                            <td>Customer Support</td>
                                            <td>New York</td>
                                            <td>27</td>
                                            <td>2011/01/25</td>
                                            <td>$112,000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </main>
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> <!-- fix table content -->
    
    <script>
        $(document).ready(function() {
            $('#spiderTable').DataTable();
            $('#passiveTable').DataTable();
            // Add similar initialization for other tables if needed
        });
    </script>

    </body>
    
</html>
