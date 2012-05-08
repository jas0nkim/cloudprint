#!/usr/bin/php -q
<?php

/*
 * ------------------------------------------------------
 *  Include files
 * ------------------------------------------------------
 */

// settings
require_once dirname(dirname(__FILE__))."/config/settings.php";

// libraries
require_once LIBSPATH."core/Common.php";
require_once LIBSPATH."core/Config.php";
require_once LIBSPATH."database/DB.php";
require_once OTHERCOMMONLIBSPATH.'static_functions.php';
require_once OTHERCOMMONLIBSPATH."String.php";
/* ------------------------------------------------------ */

$config = new CI_Config();

$db = DB();

$data = array(
    'uuid' => String::uuid($config->item('salty_salt')),
    'name' => 'Test Location 01',
    'description' => 'The first test location',
    'address' => '23 Sheppard Ave. East',
    'city' => 'North York',
    'province' => 'ON',
    'country' => 'CA',
    'status' => $config->item('active', 'location_status'),
    'created_at' => date('Y-m-d H:i:s'),
);
if ($db->insert('locations', $data)) {
    echo "[Message] A location has been inserted into database successfully\n";
} else {
    throw new Exception("[Error] Location cannot be inserted. Please check database error log.");
}

/*
 * ------------------------------------------------------
 *  Close the DB connection if one exists
 * ------------------------------------------------------
 */
if (isset($db)) {
    $db->close();
}

/* End of file s3_sync.php */