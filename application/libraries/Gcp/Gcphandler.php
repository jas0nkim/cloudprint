<?php

require_once ZENDPATH.'Loader.php';

Zend_Loader::loadClass('Zend_Http_Client');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

class Gcphandler {

    protected $options;
    protected $client;

    public function __construct($options=null) {
        $this->options = array(
            'company_name' = '',
            'gmail' => '',
            'password' => ''
        );

        if ($options) {
            $this->options = array_replace_recursive($this->options, $options);
        }

        //Actually Register the Printer
        try {
            $this->client = Zend_Gdata_ClientLogin::getHttpClient($this->options['gmail'], $this->options['password'], 'cloudprint');
        } catch (Zend_Exception $e) {
            echo "Error: " . $e;
        }

        // Get Token and Add Headers
        $Client_Login_Token = $this->client->getClientLoginToken();

        $this->client->setHeaders('Authorization','GoogleLogin auth='.$Client_Login_Token);
        $this->client->setHeaders('X-CloudPrint-Proxy',$this->options['company_name']);
    }

    /**
     * The /submit service interface is used to send print jobs to the GCP service. Upon initialization,
     * the status of the print job will be QUEUED. The print job is created and the appropriate printer
     * is notified of its existence. The status of the print job can then be tracked using /jobs, as described below.
     *
     * @param $printer_id
     * @param $title
     * @param $capabilities
     * @param $content
     * @param $content_type
     * @param $tag
     */
    public function submit($printer_id, $title, $capabilities, $content, $content_type, $tag) {

    }

    /**
     * The /jobs interface retrieves the status of print jobs for a user.
     *
     * @param null $printer_id
     */
    public function jobs($printer_id=null) {

    }

    /**
     * The /deletejob interface deletes the given print job.
     *
     * @param $job_id
     */
    public function deletejob($job_id) {

    }

    /**
     * The /printer interface retrieves the capabilities of the specified printer.
     *
     * @param $printer_id
     */
    public function printer($printer_id) {

    }

    /**
     * The /search interface returns a list of printers accessible to the authenticated authenticated user,
     * taking an optional search query as parameter.
     *
     * @param null $query
     */
    public function search($query=null) {

    }

    /**
     * This interface can be used by the printer / software connector to update Google Cloud Print about the
     * status of the print job on the printer device. The code and message parameters are useful for displaying
     * helpful information to the user via the user interface. These parameters are not used for any control,
     * disabling, or filtering of the print job or the printer.
     *
     * @param $job_id
     * @param $status
     * @param $code
     * @param $message
     */
    public function control($job_id, $status, $code, $message) {

    }

    /**
     * This interface is used to delete a printer from Google Cloud Print.
     *
     * @param $printer_id
     */
    public function delete($printer_id) {

    }

    /**
     * This interface is used to fetch the next available job for the specified printer.
     *
     * @param $printer_id
     */
    public function fetch($printer_id) {

    }

    /**
     * This interface provides a listing of all the printers for the given user. It can be used to compare
     * the printers registered and available locally. If a software connector is connected to multiple printers,
     * this interface is useful to keep the local printers and printers registered with Google Cloud Print in sync.
     * With this interface, the software connector does not need to maintain a state or mapping of the local printers
     * and needs to store only the unique proxy ID required as a parameter.
     *
     * @param $proxy
     */
    public function plist($proxy) {

    }

    /**
     * This interface is used to register printers. This should be an HTTP multipart request, since
     * the request needs to upload significantly large printer capabilities and defaults file data.
     * The capabilities and defaults parameters can be in XPS (XML Paper Specification) or PPD
     * (Postscript Printer Description) formats. Additional formats may be supported in the future to describe
     * the printer capabilities and defaults.
     *
     * @param $printer
     * @param $proxy
     * @param $capabilities
     * @param $defaults
     * @param $tag
     * @param $status
     * @param $description
     * @param $caps_hash
     */
    public function register($printer, $proxy, $capabilities, $defaults, $tag, $status, $description, $caps_hash) {

    }

    /**
     * This interface is used to update various attributes and parameters of the printer registered with Google Cloud Print.
     *
     * @param $printer_id
     * @param $printer
     * @param $display_name
     * @param $proxy
     * @param $capabilities
     * @param $defaults
     * @param $tag
     * @param $status
     * @param $description
     * @param $caps_hash
     */
    public function update($printer_id, $printer, $display_name, $proxy, $capabilities, $defaults, $tag, $status, $description, $caps_hash) {

    }
}

/* End of file Gcphandler.php */