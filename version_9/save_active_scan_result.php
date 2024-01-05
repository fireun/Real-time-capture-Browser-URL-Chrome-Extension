<?php
set_time_limit(600); // Set the time limit to 300 seconds (5 minutes)


// Retrieve JSON data from the Flask app
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Assuming $data contains the spider results and scan_id
$URL_link = $data['link'];
$domain_name = $data['domain_name']; 
$scan_id = $data['scan_id'];
$host_name = $data['active_scan_result_hosts'];
$result_alerts = $data['active_scan_result_alerts'];

// Connect to MySQL
include('db_connection.php');
// $mysqli = new mysqli("localhost", "root", "", "FYP_test_1");

// // Check connection
// if ($mysqli->connect_error) {
//     die("Connection failed: " . $mysqli->connect_error);
// }

//prevent reprint a lot times
$activeResultExist = false;
$alertInfoExist = false;

// Insert passive each alert into the database
foreach ($result_alerts as $alert) {
    // Escape values to prevent SQL injection
    foreach ($alert as $key => $value) {
        $alert[$key] = is_array($value) ? json_encode($value) : $mysqli->real_escape_string($value);
    }

    // Check if active_scan data is already available for the given fields and today's date
    $check_active_scan_sql = "SELECT COUNT(*) as count FROM `active_scan`
                             WHERE `active_domain_name` = '{$domain_name}'
                             AND `active_result_alert_name` = '{$alert['name']}'
                             AND `active_result_alert_Ref` = '{$alert['alertRef']}'
                             AND `active_result_evidence` = '{$alert['evidence']}'
                             AND `active_result_id` = '{$alert['id']}'
                             AND `active_result_URL` = '{$URL_link}'
                             AND DATE(`active_dataTime`) = CURDATE()";

    $result_active_scan = $mysqli->query($check_active_scan_sql);

    // If active_scan data not available for today, insert the data
    if ($result_active_scan && $result_active_scan->fetch_assoc()['count'] == 0) {

        // Build the SQL query for passive_scan table
        $active_scan_sql = "INSERT INTO `active_scan`
        (
        `active_zap_scan_ID`,
        `active_domain_name`,
        `active_result_alert_name`, 
        `active_result_alert_Ref`, 
        `active_result_evidence`, 
        `active_result_id`, 
        `active_result_URL`,
        `active_dataTime`
        ) VALUES (
            '{$scan_id}',
            '{$domain_name}',
            '{$alert['name']}',
            '{$alert['alertRef']}',
            '{$alert['evidence']}',
            '{$alert['id']}',
            '{$URL_link}',
            NOW()
        )";

        // Execute the query for passive_scan
        if ($mysqli->query($active_scan_sql) !== TRUE) {
            echo "Error: " . $active_scan_sql . "<br>" . $mysqli->error;
        }

    } else {
        $activeResultExist = true;
    } //end the compare of active_scan result
    

    // Check if alert_info data is already available for the given fields
    $check_alert_info_sql = "SELECT COUNT(*) as count FROM `alert_info`
        WHERE `alert_Name` = '{$alert['name']}'
        AND `alert_Ref` = '{$alert['alertRef']}'
        AND `alert_attack` = '{$alert['attack']}'
        AND `alert_confidence` = '{$alert['confidence']}'
        AND `alert_cweid` = '{$alert['cweid']}'
        AND `alert_descriptions` = '{$alert['description']}'
        AND `alert_inputVector` = '{$alert['inputVector']}'
        AND `alert_messageId` = '{$alert['messageId']}'
        AND `alert_method` = '{$alert['method']}'
        AND `alert_other` = '{$alert['other']}'
        AND `alert_param` = '{$alert['param']}'
        AND `alert_pluginId` = '{$alert['pluginId']}'
        AND `alert_risk` = '{$alert['risk']}'
        AND `alert_solution` = '{$alert['solution']}'
        AND `alert_sourceid` = '{$alert['sourceid']}'
        AND `alert_wascid` = '{$alert['wascid']}'";

    $result_alert_info = $mysqli->query($check_alert_info_sql);

    // If alert_info data not available, insert the data
    if ($result_alert_info && $result_alert_info->fetch_assoc()['count'] == 0) {

        // Build the SQL query for alert_info table
        $alert_info_sql = "INSERT INTO `alert_info` (
            `alert_Name`,
            `alert_Ref`,
            `alert_attack`,
            `alert_confidence`,
            `alert_cweid`,
            `alert_descriptions`,
            `alert_inputVector`,
            `alert_messageId`,
            `alert_method`,
            `alert_other`,
            `alert_param`,
            `alert_pluginId`,
            `alert_risk`,
            `alert_solution`,
            `alert_sourceid`,
            `alert_wascid`,
            `alert_dateTime`
        ) VALUES (
            '{$alert['name']}',
            '{$alert['alertRef']}',
            '{$alert['attack']}',
            '{$alert['confidence']}',
            '{$alert['cweid']}',
            '{$alert['description']}',
            '{$alert['inputVector']}',
            '{$alert['messageId']}',
            '{$alert['method']}',
            '{$alert['other']}',
            '{$alert['param']}',
            '{$alert['pluginId']}',
            '{$alert['risk']}',
            '{$alert['solution']}',
            '{$alert['sourceid']}',
            '{$alert['wascid']}',
            NOW()
        )";

        // Execute the query for alert_info
        if ($mysqli->query($alert_info_sql) !== TRUE) {
            echo "Error: " . $alert_info_sql . "<br>" . $mysqli->error;
        }

        // Build the SQL query for alert_url table
        $alert_url_sql = "INSERT INTO `alert_url` (
            `alert_URL_name`,
            `alert_URL_Ref`,
            `alert_URL_reference`,
            `alert_URL_tags`,
            `alert_URL_dateTime`
        ) VALUES (
            '{$alert['name']}',
            '{$alert['alertRef']}',
            '{$alert['reference']}',
            " . (isset($alert['tags']) ? "'{$alert['tags']}'" : "NULL") . ",
            NOW()
        )";

        // Execute the query for alert_url
        if ($mysqli->query($alert_url_sql) !== TRUE) {
            echo "Error: " . $alert_url_sql . "<br>" . $mysqli->error;
        }

    } else {
        $alertInfoExist = true;
    } //end the compare of alert_info
}

// Print messages outside the loop based on the results
if ($activeResultExist) {
    print("The active result is already in the database.");
}

if ($alertInfoExist) {
    print("The alert information is already in the database.");
}

// Close the MySQL connection
$mysqli->close();
?>
