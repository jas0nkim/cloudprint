<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// company/site name
$config['company_name'] = 'Freeprint';

//make this a random, unguessable, unique character string

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


/*
 * ------------------------------------------------------
 *  File upload
 * ------------------------------------------------------
 */
// local upload config
$config['local_upload']['delete_url'] = '';
$config['local_upload']['upload_dir'] = WEBROOTPATH . 'uploads/';
$config['local_upload']['upload_url'] = BASEURL . '/uploads/';
$config['local_upload']['param_name'] = 'files';
$config['local_upload']['max_file_size'] = 2097152; // 2MB
$config['local_upload']['min_file_size'] = 1;
$config['local_upload']['accept_file_types'] = '/(\.|\/)(jpe?g|png|pdf|doc)$/i'; // jpeg, jpg, png, pdf and doc
$config['local_upload']['accept_file_mime_types'] = '/image\/(jpeg|png)|application\/(pdf|msword)/i'; // image/jpeg, image/png, application/pdf and application/msword
$config['local_upload']['max_number_of_files'] = 5;
$config['local_upload']['discard_aborted_uploads'] = TRUE;
$config['local_upload']['image_versions'] = array();


// GCP
$config['gcp']['email'] = 'fpdev2012@gmail.com';
$config['gcp']['password'] = 'qwerqwer12341234';

// AWS S3
$config['awss3']['key'] = 'AKIAIQV4T3D6AEPSJITQ';
$config['awss3']['secret'] = 'MwzG2Rv61nZc6JOg2ahaqPavDNhMCy74Y019EHU';
$config['awss3']['bucket'] = 'fpdev';










// copied from libraries/uploader/config.php

// allowed extension/mime-type pair
//$allowed_file_types = array(
//    'gif' => 'image/gif',
//    'bmp' => 'image/bmp',
//    'jpeg' => 'image/jpeg',
//    'jpg' => 'image/jpeg',
//    'png' => 'image/png',
//    'doc' => 'application/msword',
//    'pdf' => 'application/pdf',
//    'txt' => 'text/plain'
//);

//define('ALLOWED_FILE_TYPES', serialize($allowed_file_types));

//define('MAX_SIZE', 2);



// moved to third_party/aws/config.inc.php



