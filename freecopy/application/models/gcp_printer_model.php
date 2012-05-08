<?php

class Gcp_printer_model extends Crud {

    /**
     * @param null $columns
     */
    public function __construct($columns=null) {
        $this->table = 'gcp_printers';
        parent::__construct($columns);
    }

}