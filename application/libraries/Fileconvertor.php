<?php
/**
 * Class Used to convert files.
 *@author jamiescott.net
 */
class Fileconvertor {

    // input folder types
    private $allowable_files = array(
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
    );
    // variable set if the constuctor loaded correctly.
    private $pass = false;

    private $config;
    // store the file name from constuctor reference
    private $file_name;

    /**
     * Enter description here...
     *
     * @param array $config
     */
    public function __construct($config=null) {
        $this->config = array(
            'doc_file_name' => '',
            'unoconv_path' => '/usr/bin/unoconv',
            'original_dir' => '/uploads/',
            'converted_dir' => '/uploads/docs_to_pdfs/',
            'apache_home' => '/home/www-data',
            'convert_file_mime_types' => '/application\/(msword|vnd\.openxmlformats\-officedocument\.wordprocessingml\.document)/i'
        );
        if ($config) {
            $this->config = array_replace_recursive($this->config, $config);
        }

        // set some shell enviroment vars
        putenv("HOME=" . $this->config['apache_home']);
        putenv("PWD=" . $this->config['apache_home']);

        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $content_type = finfo_file($finfo, $this->config['original_dir'] . $this->config['doc_file_name']);
        finfo_close($finfo);

        if (preg_match($this->config['convert_file_mime_types'], $content_type)) {
            $this->file_name = $this->config['doc_file_name'];
            $this->pass = TRUE;
        } else {
            $this->pass = FALSE;
            throw new Exception('Not supported file type: '.$this->config['original_dir'] . $this->config['doc_file_name']);
        }
    }

    /**
     * takes the file set in the constuctor and turns it into a pdf
     * stores it in /path_to_converted_dir/ and returns the file_name
     *
     * @return string
     */
    public function convert_doc_to_pdf() {
        $command = $this->config['unoconv_path'];
        $args = ' --server localhost --port 2002 --stdout -f pdf ' . $this->config['original_dir'] . $this->file_name;

        $run = $command . $args;

        //echo $run; die;
        $pdf = shell_exec($run);
        $end_of_line = strpos($pdf, "\n");
        $start_of_file = substr($pdf, 0, $end_of_line);

        if (!preg_match("/%PDF/i", $start_of_file)) {
            throw new Exception('Error Generating the PDF file');
        }

        if(!file_exists($this->config['converted_dir'])){
            mkdir($this->config['converted_dir']);
        }

        // file saved
        if(!$this->_create_and_save($pdf, $this->config['converted_dir'], $this->file_name)){
            throw new Exception('Error Saving The PDF');
        }

        return $this->config['converted_dir'] . $this->file_name;
    }

    /**
     * Create file and store data
     *
     * @param string $data
     * @param string $location
     * @param string $file
     * @return boolean
     */
    private function _create_and_save($data, $location, $file) {

        if (is_writable($location)) {
            // In our example we're opening $filename in append mode.
            // The file pointer is at the bottom of the file hence
            // that's where $somecontent will go when we fwrite() it.
            if (!$handle = fopen($location.$file, 'w')) {
                trigger_error("Cannot open file ($location$file)");
                return FALSE;
            }

            // Write $somecontent to our opened file.
            if (fwrite($handle, $data) === FALSE) {
                trigger_error("Cannot write to file ($location$file)");
                return FALSE;
            }

            fclose($handle);
            return TRUE;

        } else {
            trigger_error("The file $location.$file is not writable");
            return FALSE;
        }
    }

    public function __destruct() { }
}

/* End of file Fileconvertor.php */