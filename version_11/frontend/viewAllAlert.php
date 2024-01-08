<?php
// Include database connection and sanitation functions
include('../db_connection.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to sanitize user inputs
function sanitizeInput($input) {
    return mysqli_real_escape_string($GLOBALS['mysqli'], $input);
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
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
                    <h1 class="mt-4">All Urls Scanning Result Tables</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Tables</li>
                    </ol>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>Below here are showing all the alert be detect before.</h5>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            All URLs
                        </div>
                        <div class="card-body">
                            <table id="alertTable" class="display responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Alert Name</th>
                                        <th>Alert Ref</th>
                                        <th>Alert Attack</th>
                                        <th>Alert Confidence</th>
                                        <th>Alert CWEID</th>
                                        <th>Alert Descriptions</th>
                                        <th>Alert Input Vector</th>
                                        <th>Alert Message ID</th>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Alert Name</th>
                                        <th>Alert Ref</th>
                                        <th>Alert Attack</th>
                                        <th>Alert Confidence</th>
                                        <th>Alert CWEID</th>
                                        <th>Alert Descriptions</th>
                                        <th>Alert Input Vector</th>
                                        <th>Alert Message ID</th>
                                        <!-- Add more columns as needed -->
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php
                                    $alarmDetailsSQL = "SELECT 
                                                            `alert_ID`,
                                                            `alert_Name`, 
                                                            `alert_Ref`, 
                                                            `alert_attack`, 
                                                            `alert_confidence`, 
                                                            `alert_cweid`, 
                                                            `alert_descriptions`, 
                                                            `alert_inputVector`, 
                                                            `alert_messageId`
                                                        FROM `alert_info`
                                                        GROUP BY 
                                                            `alert_Name`, 
                                                            `alert_Ref`, 
                                                            `alert_attack`, 
                                                            `alert_confidence`, 
                                                            `alert_cweid`, 
                                                            `alert_descriptions`, 
                                                            `alert_inputVector`";
                                    $alarmDetailsSQLResult = $mysqli->query($alarmDetailsSQL);

                                    if ($alarmDetailsSQLResult->num_rows > 0) {
                                        while ($row = $alarmDetailsSQLResult->fetch_assoc()) {
                                            echo '<tr>';
                                            echo '<td> <a href="alertDetails.php?AID='. $row['alert_ID'] .'">' . $row['alert_Name'] . '</a></td>';
                                            echo '<td>' . $row['alert_Ref'] . '</td>';
                                            echo '<td>' . $row['alert_attack'] . '</td>';
                                            echo '<td>' . $row['alert_confidence'] . '</td>';
                                            echo '<td>' . $row['alert_cweid'] . '</td>';
                                            echo '<td>' . $row['alert_descriptions'] . '</td>';
                                            echo '<td>' . $row['alert_inputVector'] . '</td>';
                                            echo '<td>' . $row['alert_messageId'] . '</td>';
                                            // Add more columns as needed
                                            echo '</tr>';
                                        }
                                    } else {
                                        echo '<tr><td colspan="8">No results</td></tr>';
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

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="js/scripts.js"></script>
    <script>
         $(document).ready(function() {

            $('#alertTable').DataTable({
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

