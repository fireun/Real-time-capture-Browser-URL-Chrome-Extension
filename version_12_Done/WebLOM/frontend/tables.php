<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>WebLOM</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
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
                            <h5>Here are collect all the domain/ URLs be detect by WebLOM system</h5>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            All URLs
                        </div>
                        <div class="card-body">
                            <table id="indexdatatables" class="display responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Domain</th>
                                        <th>ScanID</th>
                                        <th>ZapScanID</th>
                                        <th>URLs</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Domain</th>
                                        <th>ScanID</th>
                                        <th>ZapScanID</th>
                                        <th>URLs</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>

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



    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
        <script>
            $(document).ready(function () {
                // Initialize DataTable
                var indexTable = $('#indexdatatables').DataTable({
                    responsive: true
                });

                function LatestTotalSpiderScanRecords(statementType) {
                    $.ajax({
                        url: 'fetch_latest_records.php',
                        method: 'POST',
                        data: {
                            action: 'getLatestSpiderScanTotal'
                        },
                        success: function (data) {
                            console.log(data);
                            $('#spiderScanTotal').html(data);
                        }
                    });
                }

                function fetchLatestRecords(statementType) {
                    $.ajax({
                        url: 'fetch_latest_records.php',
                        method: 'POST',
                        data: {
                            action: 'getLatestDomainList'
                        },
                        success: function (data) {
                            if ($.fn.DataTable.isDataTable('#indexdatatables')) {
                                // DataTable is already initialized, just update the data
                                indexTable.clear().rows.add($(data)).draw();
                            } else {
                                // DataTable is not initialized, initialize it
                                $('#indexdatatables tbody').html(data);
                                indexTable = $('#indexdatatables').DataTable({
                                    responsive: true
                                });
                            }
                        }
                    });
                }

                fetchLatestRecords('initial');
                LatestTotalSpiderScanRecords('initial');

                setInterval(function () {
                    fetchLatestRecords('periodic');
                    LatestTotalSpiderScanRecords('periodic');
                }, 5000);
            });

            // Inside the <script> tag in your first HTML file
            function fetchScanData(scanID) {
                // Set the Scan_ID in the query string and navigate to view_results.php
                window.location.href = 'scanning_result.php?scanID=' + scanID;
            }

        </script>


</body>
</html>

