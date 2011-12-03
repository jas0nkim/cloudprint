<?php

class SyncUpload extends AxUpload {

    function save($remotePath,$allowext,$add)
	{
		$msg=true;
    	foreach ($_FILES['ax-files']['error'] as $key => $error)
    	{
    		$tmp_name = $_FILES['ax-files']['tmp_name'][$key];
    		$name = $_FILES['ax-files']['name'][$key];

    		$file_info=pathinfo($name);
            if ($error == UPLOAD_ERR_OK)
            {
            	if(strpos($allowext, $file_info['extension'])!==false || $allowext=='all')
            	{
                	move_uploaded_file($tmp_name, $remotePath.$add.$name);
            	}
            	else
            	{
            		$msg=$file_info['extension'].' extension not allowed!';
            	}
            }
            else
            {
                $msg='Error uploading!';
            }
        }
        echo $msg;
        return $msg;
    }
}

/* End of custom library, SyncUpload.php */