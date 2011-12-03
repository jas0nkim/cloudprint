<?php

/*%******************************************************************************************%*/
// Configurations
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'config.php';

// CORE DEPENDENCIES
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'AxUpload.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'AsyncUpload.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'SyncUpload.php';

// PHP AWS SDK
include_once dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR . 'third_party' . DIRECTORY_SEPARATOR . 'aws' . DIRECTORY_SEPARATOR . 'sdk.class.php';

/*%******************************************************************************************%*/

class Uploader {

	private $file = false;
    
    function __construct($remote_path='') {
		if (isset($_FILES['ax-files'])) {
            $this->file = new SyncUpload($remote_path);
        } elseif (isset($_GET['ax-file-name'])) {
            $this->file = new AsyncUpload($remote_path);
        } else {
            $this->file = false;
        }
    }

    /**
     * upload files within local server
     *
     * @param string $remotePath
     * @param string $allowext
     * @param string $add
     * @return bool|string
     */
    function upload_file_local($remotePath='',$allowext='all',$add='') {
		$remotePath.=(substr($remotePath, -1)!='/')?'/':'';
        
		if(!file_exists($remotePath)) mkdir($remotePath,0777,true);

        $msg = $this->file->save($remotePath, $allowext, $add);
        return $msg;
    }

    /**
     * upload files to aws-s3 server
     *
     * @return void
     */
    function upload_file_s3($aws_key, $aws_secret_key) {
        $s3 = new AmazonS3($aws_key, $aws_secret_key);
        
    }

}


/* End of custom library, Uploader.php */