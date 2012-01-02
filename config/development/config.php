<?php

/*
|--------------------------------------------------------------------------
| Error Logging Threshold
|--------------------------------------------------------------------------
|
| If you have enabled error logging, you can set an error threshold to
| determine what gets logged. Threshold options are:
| You can enable error logging by setting a threshold over zero. The
| threshold determines what gets logged. Threshold options are:
|
|	0 = Disables logging, Error logging TURNED OFF
|	1 = Error Messages (including PHP errors)
|	2 = Debug Messages
|	3 = Informational Messages
|	4 = All Messages
|
| For a live site you'll usually only enable Errors (1) to be logged otherwise
| your log files will fill up very fast.
|
*/
$config['log_threshold'] = 0;

/*
|--------------------------------------------------------------------------
| Error Logging Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| application/logs/ folder. Use a full server path with trailing slash.
|
*/
$config['log_path'] = '';

/*
|--------------------------------------------------------------------------
| Date Format for Logs
|--------------------------------------------------------------------------
|
| Each item that is logged has an associated date. You can use PHP date
| codes to set your own date formatting
|
*/
$config['log_date_format'] = 'Y-m-d H:i:s';

/*
|--------------------------------------------------------------------------
| Cache Directory Path
|--------------------------------------------------------------------------
|
| Leave this BLANK unless you would like to set something other than the default
| system/cache/ folder.  Use a full server path with trailing slash.
|
*/
$config['cache_path'] = '';

/*
|--------------------------------------------------------------------------
| Encryption Key
|--------------------------------------------------------------------------
|
| If you use the Encryption class or the Session class you
| MUST set an encryption key.  See the user guide for info.
|
*/
$config['encryption_key'] = 'abcd1234';

$config['base_url'] = '';

$config['salty_salt'] = 'envysea_top_secret_salt';

/*
 * ------------------------------------------------------
 *  DB model status
 * ------------------------------------------------------
 */
// users
$config['user_status']['unverified'] = 0;
$config['user_status']['active'] = 1;
$config['user_status']['inactive'] = 2;
$config['user_status']['deleted'] = 3;
$config['user_status']['blocked'] = 4;

// assets
$config['asset_status']['temp'] = 0;
$config['asset_status']['active'] = 1;
$config['asset_status']['inactive'] = 2;
$config['asset_status']['deleted'] = 3;
$config['asset_status']['local'] = 4;

// print_jobs
$config['print_job_status']['processing'] = 0;
$config['print_job_status']['succeeded'] = 1;
$config['print_job_status']['pending'] = 2;
$config['print_job_status']['deleted'] = 3;
$config['print_job_status']['error'] = 4;

// printers
$config['printer_status']['candidate'] = 0;
$config['printer_status']['ready'] = 1;
$config['printer_status']['processing'] = 2;
$config['printer_status']['removed'] = 3;
$config['printer_status']['error'] = 4;

// locations
$config['printer_status']['candidate'] = 0;
$config['printer_status']['active'] = 1;
$config['printer_status']['inactive'] = 2;

// AWS
$config['aws_s3']['key'] = 'AKIAIQV4T3D6AEPSJITQ';
$config['aws_s3']['secret'] = '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';
$config['aws_s3']['bucket'] = 'fpdev';

// GCP
$config['gcp']['email'] = 'fpdev2012@gmail.com';
$config['gcp']['password'] = 'qwerqwer12341234';
