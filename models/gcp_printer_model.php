<?php

require_once dirname(__FILE__)."/crud/crud.php";

class GCP_Printer_Model extends Crud {

    /**
     * construct
     *
     * @param CI_DB_driver $db
     * @param null $columns
     */
    public function __construct($db, $columns=null) {
        $table = 'gcp_printers';
        parent::__construct($db, $table, $columns);
    }

}