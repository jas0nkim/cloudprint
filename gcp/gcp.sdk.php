<?php

// put ZENDPATH into include_path during the script run
set_include_path(get_include_path() . PATH_SEPARATOR . ZENDPATH);

require_once 'Zend/Loader.php';
require_once 'gcp_utility.php';

Zend_Loader::loadClass('Zend_Http_Client');
Zend_Loader::loadClass('Zend_Gdata_ClientLogin');

/**
 * Google Cloud Print(GCP) PHP SDK
 */
class GoogleCloudPrint {

    protected $options;
    protected $client;

    public function __construct($options=null) {
        $this->options = array(
            'company_name' => '',
            'email' => '',
            'password' => '',
            'gcp_interface_url' => 'http://www.google.com/cloudprint/interface'
        );

        if ($options) {
            $this->options = array_replace_recursive($this->options, $options);
        }

        //Actually Register the Printer
        try {
            $this->client = Zend_Gdata_ClientLogin::getHttpClient($this->options['email'], $this->options['password'], 'cloudprint');
        } catch (Zend_Gdata_App_Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        // Get Token and Add Headers
        $client_login_token = $this->client->getClientLoginToken();

        $this->client->setHeaders('Authorization','GoogleLogin auth='.$client_login_token);
        $this->client->setHeaders('X-CloudPrint-Proxy',$this->options['company_name']);
    }

    /**
     * ----------------------------------------------------
     * Submitting Print Jobs interfaces
     * ----------------------------------------------------
     */

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
     * @param string $return_type ('json' | 'object')
     * @return mixed
     */
    public function submit($printer_id, $title, $capabilities, $content, $content_type, $tag, $return_type='json') {
        //GCP Services
        $this->client->setUri($this->options['gcp_interface_url'] . '/submit');

        // set parameters
        $this->client->setParameterPost('printerid', $printer_id);
        $this->client->setParameterPost('title', $title);
        $this->client->setParameterPost('capabilities', $capabilities);
        $this->client->setParameterPost('content', $content);
        $this->client->setParameterPost('contentType', $content_type);
        $this->client->setParameterPost('tag', $tag);

        try {
            // get response by sending request to GCP
            $response = $this->client->request(Zend_Http_Client::POST);
        } catch (Zend_Http_Client_Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $this->get_return_value($response->getBody(), $return_type);
    }

    /**
     * The /jobs interface retrieves the status of print jobs for a user.
     *
     * @param null $printer_id
     * @param string $return_type ('json' | 'object')
     * @return mixed
     */
    public function jobs($printer_id=null, $return_type='json') {
        //GCP Services
        $this->client->setUri($this->options['gcp_interface_url'] . '/jobs');

        // set parameters
        $this->client->setParameterPost('printerid', $printer_id);

        try {
            // get response by sending request to GCP
            $response = $this->client->request(Zend_Http_Client::POST);
        } catch (Zend_Http_Client_Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $this->get_return_value($response->getBody(), $return_type);
    }

    /**
     * The /deletejob interface deletes the given print job.
     *
     * @param $job_id
     * @param string $return_type
     * @return mixed
     */
    public function deletejob($job_id, $return_type='json') {
        //GCP Services
        $this->client->setUri($this->options['gcp_interface_url'] . '/deletejob');

        // set parameters
        $this->client->setParameterPost('jobid', $job_id);

        try {
            // get response by sending request to GCP
            $response = $this->client->request(Zend_Http_Client::POST);
        } catch (Zend_Http_Client_Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $this->get_return_value($response->getBody(), $return_type);
    }

    /**
     * The /printer interface retrieves the capabilities of the specified printer.
     *
     * @param $printer_id
     * @param string $return_type
     * @return mixed
     */
    public function printer($printer_id, $return_type='json') {
        //GCP Services
        $this->client->setUri($this->options['gcp_interface_url'] . '/printer');

        // set parameters
        $this->client->setParameterPost('printerid', $printer_id);

        try {
            // get response by sending request to GCP
            $response = $this->client->request(Zend_Http_Client::POST);
        } catch (Zend_Http_Client_Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $this->get_return_value($response->getBody(), $return_type);
    }

    /**
     * The /search interface returns a list of printers accessible to the authenticated authenticated user,
     * taking an optional search query as parameter.
     *
     * @param null $query
     * @param string $return_type
     * @return mixed
     */
    public function search($query=null, $return_type='json') {
        //GCP Services - Register
        $this->client->setUri($this->options['gcp_interface_url'] . '/search');

        // set parameters
        $this->client->setParameterPost('q', $query);

        try {
            // get response by sending request to GCP
            $response = $this->client->request(Zend_Http_Client::POST);
        } catch (Zend_Http_Client_Exception $e) {
            echo "Error: " . $e->getMessage();
        }

        return $this->get_return_value($response->getBody(), $return_type);
    }


    /**
     * ----------------------------------------------------
     * Receiving Print Jobs interfaces
     * ----------------------------------------------------
     */

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

    /**
     * get return value from given GCP response
     *
     * @param $value
     * @param $return_type
     * @return mixed
     */
    private function get_return_value($value, $return_type) {
        if ($return_type != 'json') {
            return json_decode($value);
        }
        return $value;
    }

    /**
     * @param $printer_id
     * @param $capabilities
     * @param $file_path
     * @param $content_type
     * @return mixed
     */
    public function simple_submit($printer_id, $capabilities, $file_path, $content_type) {
        if (preg_match('/pdf$/i', $content_type)) {
            $b64_file = base64_encode($file_path);
            $content = GCP_utility::read_file($file_path);

        } elseif (preg_match('/png$/i', $content_type) || preg_match('/jpe?g$/i', $content_type)) {
            $content = GCP_utility::read_file($file_path);

        } else {
            $content = null;
        }

        $title = "FREEPRINT - ".basename($file_path)." - ".date('Y-m-d H:i:s');
        $tag = null;
        return $this->submit($printer_id, $title, $capabilities, $content, $content_type, $tag);
    }
}

/* End of file gcp.sdk.php */
