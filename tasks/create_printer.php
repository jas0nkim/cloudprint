#!/usr/bin/php -q
<?php

/*
 * ------------------------------------------------------
 *  Load required files
 * ------------------------------------------------------
 */

// load settings
require_once dirname(dirname(__FILE__))."/config/settings.php";

// load base libraries
require_once LIBSPATH."core/Common.php";
require_once LIBSPATH."core/Config.php";
require_once LIBSPATH."database/DB.php";
require_once OTHERCOMMONLIBSPATH.'static_functions.php';
require_once OTHERCOMMONLIBSPATH."String.php";

// load modals
require_once MODELPATH."gcp_printer_model.php";

// load GCP libraries
require_once GCPPATH."gcp.sdk.php";
require_once LIBSPATH."GCPhandler.php";


/* ------------------------------------------------------ */

$config = new CI_Config();

// testing db class
$db = DB();

// create GCP printer
$gcp_options = array(
    'company_name' => $config->item('company_name'),
    'email' => $config->item('email', 'gcp'),
    'password' => $config->item('password', 'gcp')
);
$gcp = new GCPhandler($gcp_options, $db);
$gcp->create_gcp_printers();

// create printer
$data = array(
    'uuid' => String::uuid($config->item('salty_salt')),
    'gcp_printer_id' => 1,
    'location_id' => 1,
    'status' => $config->item('ready', 'printer_status'),
    'created_at' => date('Y-m-d H:i:s'),
);
if ($db->insert('printers', $data)) {
    echo "[Message] A printer has been inserted into database successfully\n";
} else {
    throw new Exception("[Error] Printer cannot be inserted. Please check database error log.");
}

/*
 * ------------------------------------------------------
 *  Close the DB connection if one exists
 * ------------------------------------------------------
 */
if (isset($db)) {
    $db->close();
}


/* End of file gcp_printerinfo.php */
