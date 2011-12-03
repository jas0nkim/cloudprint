<?php

// allowed extension/mime-type pair
$allowed_file_types = array(
    'gif' => 'image/gif',
    'bmp' => 'image/bmp',
    'jpeg' => 'image/jpeg',
    'jpg' => 'image/jpeg',
    'png' => 'image/png',
    'doc' => 'application/msword',
    'pdf' => 'application/pdf',
    'txt' => 'text/plain'
);

define('ALLOWED_FILE_TYPES', serialize($allowed_file_types));

define('MAX_SIZE', 2);

/* End of custom library, config.php */