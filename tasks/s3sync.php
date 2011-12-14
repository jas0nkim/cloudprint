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
require_once LIBSPATH."S3handler.php";
/* ------------------------------------------------------ */


$config = new CI_Config();

// AWS S3
$options = array(
    'aws_s3_key' => $config->item('key', 'aws_s3'),
    'aws_s3_secret' => $config->item('secret', 'aws_s3'),
    'aws_s3_bucket' => $config->item('bucket', 'aws_s3')
);
$s3 = new S3handler($options);

// testing db class
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