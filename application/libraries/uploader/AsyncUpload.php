<?php

class AsyncUpload
{
    function save($remotePath,$allowext,$add)
	{
	    $file_name=$_GET['ax-file-name'];

	    $file_info=pathinfo($file_name);

	    if(strpos($allowext, $file_info['extension'])!==false || $allowext=='all')
	    {
	    	$flag =($_GET['start']==0) ? 0:FILE_APPEND;
	    	$file_part=file_get_contents('php://input');//REMEMBER php::/input can be read only one in the same script execution, so better mem it in a var
	    	while(@file_put_contents($remotePath.$add.$file_name, $file_part,$flag)===FALSE)//strange bug
	    	{
	    		usleep(50);
	    	}
	        return true;
	    }
	    return $file_info['extension'].' extension not allowed to upload!';
    }
}

/* End of custom library, AsyncUpload.php */