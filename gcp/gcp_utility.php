<?php

class GCP_utility {

    /**
     * read contents of a file and return contents
     *
     * @static
     * @param string $file_path
     * @param bool $encoded
     * @return null | string
     */
    public static function read_file($file_path, $encoded=FALSE) {
        if ($encoded) {
            $file_path = base64_decode($file_path);
        }

        $contents = null;
        $handle = fopen($file_path, "rb");
        if ($handle) {
            $contents = fread($handle, filesize($file_path));
            fclose($handle);
        }
        return $contents;
    }

    /**
     * read contents of a file from remote and return contents
     * @static
     * @param string $file_url
     * @param bool $encoded
     * @return null | string
     */
    public static function read_remote_file($file_url, $encoded=FALSE) {
        if ($encoded) {
            $file_path = base64_decode($file_url);
        }

        $contents = null;
        $handle = fopen($file_url, "rb");
        if ($handle) {
            $contents = stream_get_contents($handle);
            fclose($handle);
        }
        return $contents;
    }

}
/* End of file gcp_utility.php */