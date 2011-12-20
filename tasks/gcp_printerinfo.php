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
require_once GCPPATH."gcp.sdk.php";
require_once LIBSPATH."GCPhandler.php";
/* ------------------------------------------------------ */

$config = new CI_Config();

// GCP
$gcp_options = array(
    'company_name' => $config->item('company_name'),
    'email' => $config->item('email', 'gcp'),
    'password' => $config->item('password', 'gcp')
);

$gcp = new GCPhandler($gcp_options);
$gcp->create_printer();

/* End of file gcp_printerinfo.php */
