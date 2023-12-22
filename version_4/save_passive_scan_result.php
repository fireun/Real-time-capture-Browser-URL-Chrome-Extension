<?php
// Retrieve JSON data from the Flask app
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Assuming $data contains the spider results and scan_id
$URL_link = $data['link'];
$domain_name = $data['domain_name']; 
$scan_id = $data['scan_id'];
$host_name = $data['passive_results_hosts'];
$result_alerts = $data['passive_result_alerts'];

// Connect to MySQL
$mysqli = new mysqli("localhost", "root", "", "FYP_test_1");

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Insert passive each alert into the database
foreach ($result_alerts as $alert) {
    // Escape values to prevent SQL injection
    foreach ($alert as $key => $value) {
        $alert[$key] = is_array($value) ? json_encode($value) : $mysqli->real_escape_string($value);
    }

    // Build the SQL query for passive_scan table
    $passive_scan_sql = "INSERT INTO `passive_scan` (
        `passive_zap_scan_ID`,
        `passive_domain_name`,
        `passive_result_alert_name`,
        `passive_result_alert_Ref`,
        `passive_result_evidence`,
        `passive_result_id`,
        `passive_result_URL`,
        `passive_dataTime`
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
    if ($mysqli->query($passive_scan_sql) !== TRUE) {
        echo "Error: " . $passive_scan_sql . "<br>" . $mysqli->error;
    }

    // Build the SQL query for alert_info table
    $alert_info_sql = "INSERT INTO `alert_info` (
        `alert_Name`,
        `alert_Ref`,
        `alert_attack`,
        `alert_confidence`,
        `alert_cweird`,
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
}

// Close the MySQL connection
$mysqli->close();
?>
