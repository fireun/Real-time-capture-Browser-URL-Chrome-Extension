/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


window.addEventListener('DOMContentLoaded', event => {
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    $('#indexdatatables').DataTable();
    
    $('#datatablesSimple').DataTable({searching: true,}); //table page

    // // scanning_result.php  //
    // // DataTable initialization 
    // $('#spiderTable, #passiveTable, #activeTable').DataTable();
    
});




// index.php & table.php 
// //display the single domain scanning result
// function fetchScanData() {
//     // Get the Scan_ID from the input field
//     var scanID = document.getElementById('scanID').value;

//     // Set the Scan_ID in the query string of the link
//     var link = document.getElementsByTagName('a')[0];
//     link.href = 'scanning_result.php?scanID=' + scanID;
// }




