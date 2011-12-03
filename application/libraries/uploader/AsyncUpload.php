<?php

class AsyncUpload {

    protected $file_name;
    protected $ext;
    protected $mime_type;
    protected $size;
    protected $remote_path;

    public function __construct($remote_path='') {
        $file_info = pathinfo($_GET['ax-file-name']);
        
        $this->file_name = $file_info['basename'];
        $this->ext = $file_info['extension'];
        $this->mime_type = $this->_get_mime_type();
        $this->size = 0;
        $this->remote_path = $remote_path;
    }

    private function _get_mime_type() {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        
        if (!$finfo) {
            echo "Opening fileinfo database failed";
            die();
        }

        $file = file_get_contents('php://input');

        return $finfo->buffer($file);
    }

    public function validate() {

    }

    public function save($remote_path, $allowext, $additional_path) {
	    //$file_name = $_GET['ax-file-name'];

	    $file_info = pathinfo($file_name);

	    if(strpos($allowext, $file_info['extension'])!==false || $allowext=='all')
	    {
	    	$flag =($_GET['start']==0) ? 0:FILE_APPEND;
	    	$file_part=file_get_contents('php://input');//REMEMBER php::/input can be read only one in the same script execution, so better mem it in a var
	    	while(@file_put_contents($remote_path.$additional_path.$file_name, $file_part,$flag)===FALSE)//strange bug
	    	{
	    		usleep(50);
	    	}
	        return true;
	    }
	    return $file_info['extension'].' extension not allowed to upload!';
    }
}

/* End of custom library, AsyncUpload.php */