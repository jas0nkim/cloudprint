#!/usr/bin/php -q
<?php
// settings
require_once dirname(dirname(__FILE__))."/config/settings.php";

// include pre-required
require_once BASEPATH."core/Common.php";
require_once BASEPATH."database/DB.php";

$db = DB();

$query = $db->query("select * from assets");
print_r($query->result());



/*
 * ------------------------------------------------------
 *  Close the DB connection if one exists
 * ------------------------------------------------------
 */
if (isset($db)) {
    $db->close();
}

/* End of file s3Sync.php */