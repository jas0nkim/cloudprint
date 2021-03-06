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
$config['location_status']['candidate'] = 0;
$config['location_status']['active'] = 1;
$config['location_status']['inactive'] = 2;


/*
 * ------------------------------------------------------
 *  File upload
 * ------------------------------------------------------
 */
// local upload config
$config['local_upload']['delete_url'] = BASEURL . '/members/file_delete';
$config['local_upload']['upload_dir'] = WEBROOTPATH . 'uploads/';
$config['local_upload']['upload_url'] = BASEURL . '/uploads/';
$config['local_upload']['param_name'] = 'files';
$config['local_upload']['max_file_size'] = 2097152; // 2MB
$config['local_upload']['min_file_size'] = 1;
$config['local_upload']['accept_file_types'] = '/(\.|\/)(jpe?g|png|pdf|docx?)$/i'; // jpeg, jpg, png, pdf, doc and docx
$config['local_upload']['accept_file_mime_types'] = '/image\/(jpeg|png)|application\/(pdf|msword|vnd\.openxmlformats\-officedocument\.wordprocessingml\.document)/i';
    // image/jpeg, image/png, application/pdf, application/msword and application/vnd.openxmlformats-officedocument.wordprocessingml.document
$config['local_upload']['max_number_of_files'] = null;
$config['local_upload']['discard_aborted_uploads'] = TRUE;
$config['local_upload']['image_versions'] = array();

/*
 * ------------------------------------------------------
 *  File conversion - .doc(x) to .pdf
 * ------------------------------------------------------
 */
$config['local_file_conv']['convert_file_mime_types'] = '/application\/(msword|vnd\.openxmlformats\-officedocument\.wordprocessingml\.document)/i';
$config['local_file_conv']['unoconv_path'] = '/usr/bin/unoconv';
$config['local_file_conv']['original_dir'] = WEBROOTPATH . 'uploads/';
$config['local_file_conv']['converted_dir'] = WEBROOTPATH . 'uploads/docs_to_pdfs/';
$config['local_file_conv']['apache_home'] = '/home/www-data';


// GCP
$config['gcp']['email'] = 'fpdev2012@gmail.com';
$config['gcp']['password'] = 'qwerqwer12341234';

// AWS S3
$config['awss3']['key'] = 'AKIAIQV4T3D6AEPSJITQ';
$config['awss3']['secret'] = 'MwzG2Rv61nZc6JOg2ahaqPavDNhMCy74Y019EHU';
$config['awss3']['bucket'] = 'fpdev';

// LiveDocx
$config['livedocx']['username'] = 'fpdev2012';
$config['livedocx']['password'] = 'qwer1234';


/* End of file custom_config.php */


