<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//make this a random, unguessable, unique character string

$config['salty_salt'] = 'envysea_top_secret_salt';

// AWS S3
$config['awss3']['key'] = 'AKIAIQV4T3D6AEPSJITQ';
$config['awss3']['secret'] = 'MwzG2Rv61nZc6JOg2ahaqPavDNhMCy74Y019EHU';
$config['awss3']['bucket'] = 'fpdev';

// moved to libraries/uploader/config.php

// upload configuration
//$config['upload']['upload_path'] = WEBROOTPATH.'uploads/';
//$config['upload']['allowed_types'] = 'gif|jpg|png';
//$config['upload']['max_size']	= '100';
//$config['upload']['max_width']  = '1024';
//$config['upload']['max_height']  = '768';

// allowed mime types in regular expression
$config['upload']['accept_file_types'] = '/.+$/i';




// allowed extension/mime-type pair
$config['upload']['allowed_types'] = array(
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'png' => 'image/png',
    'doc' => 'application/msword',
    'pdf' => 'application/pdf',
    'txt' => 'text/plain'
);




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



