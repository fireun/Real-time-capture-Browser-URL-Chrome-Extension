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
                                <table id="spiderTable" class="display">
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
                                            <th>Country</th>
                                            <th>Languages</th>
                                            <th>Population</th>
                                            <th>Median Age</th>
                                            <th>Area (Km²)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Argentina</td>
                                            <td>Spanish (official), English, Italian, German, French</td>
                                            <td>41,803,125</td>
                                            <td>31.3</td>
                                            <td>2,780,387</td>
                                        </tr>
                                        <tr>
                                            <td>Australia</td>
                                            <td>English 79%, native and other languages</td>
                                            <td>23,630,169</td>
                                            <td>37.3</td>
                                            <td>7,739,983</td>
                                        </tr>
                                        <tr>
                                            <td>Greece</td>
                                            <td>Greek 99% (official), English, French</td>
                                            <td>11,128,404</td>
                                            <td>43.2</td>
                                            <td>131,956</td>
                                        </tr>
                                        <tr>
                                            <td>Luxembourg</td>
                                            <td>Luxermbourgish (national) French, German (both administrative)</td>
                                            <td>536,761</td>
                                            <td>39.1</td>
                                            <td>2,586</td>
                                        </tr>
                                        <tr>
                                            <td>Russia</td>
                                            <td>Russian, others</td>
                                            <td>142,467,651</td>
                                            <td>38.4</td>
                                            <td>17,076,310</td>
                                        </tr>
                                        <tr>
                                            <td>Sweden</td>
                                            <td>Swedish, small Sami- and Finnish-speaking minorities</td>
                                            <td>9,631,261</td>
                                            <td>41.1</td>
                                            <td>449,954</td>
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
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    </body>
</html>
