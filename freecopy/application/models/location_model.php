<?php

class Location_model extends Crud {

    /**
     * @param null $columns
     */
    public function __construct($columns=null) {
        $this->table = 'locations';
        parent::__construct($columns);
    }

    /**
     * @param int $status default status = 'active'
     * @return \Array
     */
    public function list_locations($status=null) {
        if ($status == null) {
            $status = $this->config->item('active', 'location_status');
        }

        $option = array('status' => $status);
        return $this->select_all_where($option);
    }
}