<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crud_timestampable
 *
 * @author jkim
 */
class Crud_timestampable extends Crud {

    var $created_at;
    var $updated_at;

    /**
     * construct
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * set created_at
     *
     * @param String $created_at
     */
    public function set_created_at($created_at = null) {
        $this->created_at = ($created_at != null) ? $created_at : $this->created_at;
    }

    /**
     * set updated_at
     *
     * @param String $updated_at
     */
    public function set_updated_at($updated_at = null) {
        $this->updated_at = ($updated_at != null) ? $updated_at : $this->updated_at;
    }

    /**
     * insert entry
     *
     * @param stdClass $data
     * @return Object
     */
    public function insert_entry($data = null) {
        $this->_timestamp_on_insert();
        $data->created_at = $this->created_at;
        $data->updated_at = $this->updated_at;

        return parent::insert_entry($data);
    }

    /**
     * update entry
     *
     * @param stdClass $data
     * @return Object | FALSE
     */
    public function update_entry($data = null) {
        $this->_timestamp_on_update();
        $data->updated_at = $this->updated_at;

        return parent::update_entry($data);
    }

    /**
     * timestamp on insert
     */
    protected function _timestamp_on_insert() {
        $this->set_created_at(date('Y-m-d H:i:s', time()));
        $this->set_updated_at(date('Y-m-d H:i:s', time()));
    }

    /**
     * timestamp on update
     */
    protected function _timestamp_on_update() {
        $this->set_created_at();
        $this->set_updated_at(date('Y-m-d H:i:s', time()));
    }
}

