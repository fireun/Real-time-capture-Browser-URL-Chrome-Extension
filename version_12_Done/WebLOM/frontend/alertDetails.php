<?php
// Include database connection and sanitation functions
include('../db_connection.php');

// Function to sanitize user inputs
function sanitizeInput($input) {
    return mysqli_real_escape_string($GLOBALS['mysqli'], $input);
}

if (isset($_GET['AID'])) {
   
    $alarmDetailsSQL = "SELECT * FROM `alert_info` WHERE alert_ID = " . sanitizeInput($_GET['AID']);
                                                       
    $alarmDetailsSQLResult = $mysqli->query($alarmDetailsSQL);

    // Check the number of rows
    //$passiveRow = mysqli_num_rows($passiveScanResult);
    $no = 0;

    // // Output the results in a table
    // echo '<p>Number of rows: ' . $numRows . '</p>';
    if ($alarmDetailsSQLResult->num_rows > 0) {
        while ($row = $alarmDetailsSQLResult->fetch_assoc()) {
            //$escapedHtmlData = htmlspecialchars($row['passive_result_evidence'], ENT_QUOTES, 'UTF-8'); //transfer to text only

            $alert_name = $row['alert_Name'];
            $alert_ref = $row['alert_Ref'];
            $alert_attack = $row['alert_attack'];
            $alert_confidence = $row['alert_confidence'];
            $alert_cweid = $row['alert_cweid'];
            $alert_description = $row['alert_descriptions'];
            $alert_inputVector = $row['alert_inputVector'];
            $alert_messageId = $row['alert_messageId'];
            $alert_method = $row['alert_method'];
            $alert_param = $row['alert_param'];
            $alert_plugin = $row['alert_pluginId'];
            $alert_risk = $row['alert_risk'];
            $alert_solution = $row['alert_solution'];
            $alert_sourceid = $row['alert_sourceid'];
            $alert_wascid = $row['alert_wascid'];
            $alert_date = $row['alert_dateTime'];
            $alert_other = $row['alert_other'];
        }
    } else {
        echo '<p>No results found for Scan ID: ' . $selectedScanID . '</p>';
    }

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
        <title>WebLOM - Alert Details</title>

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
                            <li class="breadcrumb-item"><a href="viewAllAlert.php">All Alert</a></li>
                            <li class="breadcrumb-item active">AlertDetails: <?php echo $alert_name;?></li>
                        </ol>
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5>Below here is all the information about this alert.</h5>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <!-- Columns are always 50% wide, on mobile and desktop -->
                            <div class="row m-3">
                                <h2>Alert Info</h2>
                                
                                <div class="col-6">
                                    <h5>Alert ID: <?php echo $_GET['AID']; ?></h5>
                                    <h5>Alert Name: <?php echo $alert_name;?></h5>
                                    <h5>Alert Ref: <?php echo $alert_ref;?> </h5>
                                    <h5>Alert Attack: <?php echo $alert_attack;?> </h5>
                                    <h5>Alert Confidence: <?php echo $alert_confidence;?></h5>
                                    <h5>Alert Risk: <?php echo $alert_risk;?></h5>
                                    <h5>Alert Method: <?php echo $alert_method;?> </h5>
                                    <h5>Alert Param: <?php echo $alert_param;?></h5>
                                    <h5>Alert Description:</h5> <p><?php echo $alert_description;?> </p>
                                    
                                </div>
                                <div class="col-6">
                                    <h5>Alert Input Vector: <?php echo $alert_inputVector;?></h5>
                                    <h5>Alert CWE ID: <?php echo $alert_cweid;?></h5>
                                    <h5>Alert Message ID: <?php echo $alert_messageId;?></h5>
                                    <h5>Alert Plugin ID: <?php echo $alert_plugin;?></h5>
                                    <h5>Alert Source ID: <?php echo $alert_sourceid;?></h5>
                                    <h5>Alert WASC ID: <?php echo $alert_wascid;?></h5>
                                    <h5>Alert Solution:</h5> <p><?php echo $alert_solution;?></p>
                                    
                                </div>
                            </div>

                            <div class="row m-3">
                                <h5>other: </h5><p><?php echo $alert_other;?></p>
                            </div>

                            <hr class="border border-1 opacity-100">

                            <div class="row m-3">
                                <h2>Related Urls</h2>
                                <div class="col-xs-12">
                                    <table id="urlTable" class="table table-bordered border table-hover display responsive nowrap dataTable">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>URL ID</th>
                                                <th>URL name</th>
                                                <th>URL Ref</th>
                                                <th>URL reference</th>
                                                <th>URL tags</th>
                                                <th>URL Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                            if (isset($_GET['AID'])) {

                                                    // Retrieve Passive Scan data within a 10-minute window
                                                    $getURL = "SELECT 
                                                                    u.`alert_URL_Id`, 
                                                                    u.`alert_URL_name`, 
                                                                    u.`alert_URL_Ref`, 
                                                                    u.`alert_URL_reference`, 
                                                                    u.`alert_URL_tags`, 
                                                                    u.`alert_URL_dateTime`
                                                                FROM 
                                                                    `alert_info` a
                                                                LEFT JOIN 
                                                                    `alert_url` u ON a.`alert_Name` = u.`alert_URL_name` AND a.`alert_Ref` = u.`alert_URL_Ref`
                                                                WHERE 
                                                                    a.`alert_ID` = '" . sanitizeInput($_GET['AID']) . "'
                                                                GROUP BY 
                                                                    u.`alert_URL_name`, 
                                                                    u.`alert_URL_Ref`, 
                                                                    u.`alert_URL_reference`, 
                                                                    u.`alert_URL_tags`";
                                                                
                    
                                                    $result = $mysqli->query($getURL);

                                                    // Check the number of rows
                                                    //$passiveRow = mysqli_num_rows($passiveScanResult);
                                                    $no = 0;

                                                    // // Output the results in a table
                                                    // echo '<p>Number of rows: ' . $numRows . '</p>';
                                                    if ($result->num_rows > 0) {
                                                        while ($url = $result->fetch_assoc()) {
                                                            //$escapedHtmlData = htmlspecialchars($passiveRow['passive_result_evidence'], ENT_QUOTES, 'UTF-8'); //transfer to text only

                                                            echo '<tr>';
                                                            echo '<td>' . $no . '</td>';
                                                            echo '<td>' . $url['alert_URL_Id'] . '</td>';
                                                            echo '<td>' . $url['alert_URL_name'] . '</td>';
                                                            echo '<td>' . $url['alert_URL_Ref'] . '</td>';
                                                            echo '<td>' . $url['alert_URL_reference'] . '</td>';
                                                            echo '<td>' . $url['alert_URL_tags'] . '</td>';
                                                            echo '<td>' . $url['alert_URL_dateTime'] . '</td>';
                                                            echo '</tr>';
                                                            $no ++;
                                                        }
                                                    }else {
                                                        echo '<p>No results found</p>';
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

                        <!-- SELECT `alert_ID`, `alert_Name`, `alert_Ref`, `alert_attack`,
                         `alert_confidence`, `alert_cweid`, `alert_descriptions`,
                          `alert_inputVector`, `alert_messageId`, `alert_method`, 
                          `alert_other`, `alert_param`, `alert_pluginId`, `alert_risk`,
                           `alert_solution`, `alert_sourceid`, `alert_wascid`,
                            `alert_dateTime` FROM `alert_info` WHERE 1 -->


                        <!-- SELECT `alert_URL_Id`, `alert_URL_name`, `alert_URL_Ref`, 
                        `alert_URL_reference`, `alert_URL_tags`, `alert_URL_dateTime`
                    FROM `alert_url` WHERE 1 -->

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
            $('#urlTable').DataTable({
                "processing": true,
                "scrollY": "400px", // Adjust the height as needed
                "scrollX": true,    // Enable horizontal scrolling
                "scrollCollapse": true,
                "paging": true,   // Disable pagination for vertical scrolling
            });

            
        });
    </script>
    
    </body>
    
</html>
