<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//make this a random, unguessable, unique character string

$config['salty_salt'] = 'envysea_top_secret_salt';

// upload configuration

$config['upload']['upload_path'] = WEBROOTPATH.'uploads/';
$config['upload']['allowed_types'] = 'gif|jpg|png';
$config['upload']['max_size']	= '100';
$config['upload']['max_width']  = '1024';
$config['upload']['max_height']  = '768';

