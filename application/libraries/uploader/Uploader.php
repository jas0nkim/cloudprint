<?php

/*%******************************************************************************************%*/
// CORE DEPENDENCIES

include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'AsyncUpload.php';
include_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'SyncUpload.php';

/*%******************************************************************************************%*/

class Uploader {

	private $file = false;
    
    function __construct($remotePath='',$allowext='') {
		if (isset($_FILES['ax-files'])) {
            $this->file = new SyncUpload();
        } elseif(isset($_GET['ax-file-name'])) {
            $this->file = new AsyncUpload();
        } else {
            $this->file = false;
        }
    }

    function upload_file($remotePath='',$allowext='all',$add='') {
		$remotePath.=(substr($remotePath, -1)!='/')?'/':'';
        
		if(!file_exists($remotePath)) mkdir($remotePath,0777,true);

        $msg = $this->file->save($remotePath,$allowext,$add);
        return $msg;
    }

}


/* End of custom library, Uploader.php */