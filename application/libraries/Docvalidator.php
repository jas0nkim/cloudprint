<?php
// put ZENDPATH into include_path during the script run
set_include_path(get_include_path() . PATH_SEPARATOR . ZENDPATH);

require_once 'Zend/Loader.php';

Zend_Loader::loadClass('Zend_Service_LiveDocx_MailMerge');

class Docvalidator {

    protected $options;

    public function __construct($options=null) {
        $this->set_options($options);
    }

    /**
     * @param array|null $options
     * @throws Exception
     */
    public function set_options($options=array()) {
        if (!is_array($options)) {
            throw new Exception('Options must be in associated array form.');
        }

        foreach ($options as $k => $v) {
            $this->options[$k] = $options;
        }
    }

    /**
     * @param $key string
     * @return bool | string
     */
    public function get_option($key) {
        if (isset($key)) {
            if (array_key_exists($key, $this->options)) {
                return $this->options[$key];
            }
        }

        return FALSE;
    }

    /**
     * @param $file_name
     */
    public function get_numb_of_pages($file_name) {
        if (Docvalidator::is_doc($file_name)) {
            return $this->get_doc_numb_of_pages($file_name);
        } elseif (Docvalidator::is_pdf($file_name)) {
            return $this->get_pdf_numb_of_pages($file_name);
        }
    }

    private function get_doc_numb_of_pages($file_name) {

    }

    private function get_pdf_numb_of_pages($file_name) {

    }

    /**
     * @static
     * @param $file_name
     * @return bool
     */
    private static function is_doc($file_name) {
        return get_file_extension($file_name) == 'doc';
    }

    /**
     * @static
     * @param $file_name
     * @return bool
     */
    private static function is_pdf($file_name) {
        return get_file_extension($file_name) == 'pdf';
    }

}

/* End of file Docvalidator.php */