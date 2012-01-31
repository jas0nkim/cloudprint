<?php

class GCP_utility {

    /**
     * read contents of a file and return contents
     *
     * @static
     * @param string $file_path
     * @return null | string
     */
    public static function read_file($file_path) {
        return file_get_contents($file_path);
    }

    /**
     * read contents of a file from remote and return contents
     * @static
     * @param string $file_url
     * @return null | string
     */
    public static function read_remote_file($file_url) {
        $contents = null;
        $handle = fopen($file_url, "rb");
        if ($handle) {
            $contents = stream_get_contents($handle);
            fclose($handle);
        }
        return $contents;
    }

    /**
     * write contents of data to a file_name
     * @static
     * @param $file_name
     * @param $data
     * @return bool
     */
    public static function write_file($file_name, $data) {
        $status = TRUE;
        $handle = fopen($file_name, "wb");
        if (fwrite($handle, $data) === FALSE) {
            $status = FALSE;
        }
        fclose($handle);

        return $status;
    }

    /**
     * convert a file to a base64 encoded file
     * @static
     * @param $file_path
     * @return null|string
     */
    public static function base_64_encode($file_path) {
        $b64_file_path = $file_path . ".b64";
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $content_type = finfo_file($finfo, $file_path);
        finfo_close($finfo);
        $data = self::read_file($file_path);

        $header = 'data:' . $content_type . ';base64,';
        $b64_data = $header . base64_encode($data);

        if (self::write_file($b64_file_path, $b64_data)) {
            return $b64_file_path;
        } else {
            return null;
        }
    }

}
/* End of file gcp_utility.php */