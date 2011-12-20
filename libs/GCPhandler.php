<?php

class GCPhandler {
    private $db;
    private $gcp_printers_db    = 'gcp_printers';   // database table name for GCP printer's information 
    private $printers_db        = 'printers';       // database table name for general printer's information

    private $gcp;

    /**
     * construct
     *
     * @param null $gcp_options
     * @internal param null $options
     */
    public function __construct($gcp_options=null) {
        $this->db = DB();

        $default_gcp_options = array(
             'company_name' => '',
             'email' => '',
             'password' => '',
         );

         if ($gcp_options) {
             $gcp_options = array_replace_recursive($default_gcp_options, $gcp_options);
         } else {
             $gcp_options = $default_gcp_options;
         }

         try {
             $this->gcp = new GoogleCloudPrint($gcp_options);
         } catch (Exception $e) {
             echo "Error: " . $e;
         }
    }

    /**
     * destruct
     */
    public function __destruct() {
        if (isset($this->db)) {
            $this->db->close();
        }
    }

    public function create_printer() {
        print_r(json_decode($this->gcp->search()));
    }

}
