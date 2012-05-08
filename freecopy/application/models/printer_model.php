<?php

class Printer_model extends Crud {

    /**
     * @param null $columns
     */
    public function __construct($columns=null) {
        $this->table = 'printers';
        parent::__construct($columns);
    }

    /**
     * @param int $status default status = 'ready'
     * @return \Array
     */
    public function list_printers($status=null) {
        if ($status == null) {
            $status = $this->config->item('ready', 'printer_status');
        }

        $option = array('status' => $status);
        return $this->select_all_where($option);
    }
}