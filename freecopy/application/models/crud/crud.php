<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Crud
 *
 * @author jkim
 */
class Crud extends CI_Model {

    // database: table
    protected $table;

    // database: columns
    protected $columns = array();

    /**
     * construct
     *
     * @param null $columns
     */
    public function __construct($columns=null) {
        $this->columns = array();
        if ($columns) {
            $this->columns = array_replace_recursive($this->columns, $columns);
        }

        parent::__construct();
    }


    /**
     * override CI_Model __get()
     * Allows models to access CI's loaded classes using the same
     * syntax as controllers,
     * and also database object column values.
     *
     * @param $key
     * @return Mixed
     */
    public function __get($key) {
        if (array_key_exists($key, $this->columns)) {
            return $this->columns[$key];
        }

        $CI =& get_instance();
        return $CI->$key;
    }

    /**
     * Allows to set value in database column
     *
     * @param $key
     * @param $value
     * @return void
     */
    public function __set($key, $value) {
        $this->columns[$key] = $value;
    }

    /**
     * check the key is in database column
     *
     * @param $key
     * @return bool
     */
    public function __isset($key) {
        return isset($this->columns[$key]);
    }

    /**
     * unset the key
     *
     * @param $key
     * @return void
     */
    public function __unset($key) {
        unset($this->columns[$key]);
    }

    /**
     * @param $query
     * @param $result_type
     * @return mixed
     */
    protected function get_result($query, $result_type) {
        if ($result_type == 'object') {
            $result = $query->result();
        } elseif ($result_type == 'array') {
            $result = $query->result_array();
        }
        $query->free_result();
        return $result;
    }

    /**
     * select all records
     *
     * @param string $result_type 'object' or 'array'
     * @return array
     */
    public function select_all($result_type='object') {
        $query = $this->db->get($this->table);
        return $this->get_result($query, $result_type);
    }

    /**
     * select all records with given field name and value
     *
     * @param array $conditions : $field => $value pairs
     * @param string $result_type 'object' or 'array'
     * @return array
     */
    public function select_all_where($conditions, $result_type='object') {
        $this->_select_where($conditions);
        $query = $this->db->get();
        return $this->get_result($query, $result_type);
    }

    /**
     * select a record with given primary key
     *
     * @param mixed $primary_key
     * @param string $result_type 'object' or 'array'
     * @return array
     */
    public function select_one($primary_key, $result_type='object') {
        $query = $this->db->get_where($this->table, array('id' => $primary_key), 1, 0);
        return $this->get_result($query, $result_type);
    }

    /**
     * select a record with given field name and value
     *
     * @param array $conditions : $field => $value pairs
     * @param string $result_type 'object' or 'array'
     * @return array
     */
    public function select_one_where($conditions, $result_type='object') {
        $query = $this->db->get_where($this->table, $conditions, 1, 0);
        return $this->get_result($query, $result_type);
    }

    /**
     * get count of results
     *
     * @param Array $conditions
     * @return Integer
     */
    public function select_all_where_count($conditions) {
        $this->_select_where($conditions);
        return $this->db->count_all_results();

    }

    /**
     * set query conditions
     *
     * @param Array $conditions : $field => $value pairs
     * @return Void
     */
    protected function _select_where($conditions) {
        $this->db->select('*');
        $this->db->from($this->table);
        foreach ($conditions as $field => $value) {
            $this->db->where($field, $value);
        }
        return;
    }

    /**
     * insert entry
     *
     * @param array $data
     * @return Integer last inserted id
     */
    public function insert_entry($data=null) {
        if (!is_array($data)) {
            $data = $this->columns;
        }
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    /**
     * update entry
     *
     * @param stdClass $data
     * @return Object | FALSE
     */
    public function update_entry($data=null) {
        if (!isset($data->id) || is_null($data->id)) {
            if (!isset($this->id) || is_null($this->id)) {
                return FALSE;
            } else {
                $this_id = $this->id;
            }
        } else {
            $this_id = $data->id;
        }
        return $this->db->update($this->table, $data, array('id' => $this_id));
    }

    /**
     * delete entry
     *
     * @param array|string $data
     * @return bool
     */
    public function delete_entry($data=null) {
        if (is_null($data)) {
            return FALSE;
        }

        if (!is_array($data)) { // $data is primary key
            return $this->db->delete($this->table, array('id' => $data));
        } else { // $data is associated array
            return $this->db->delete($this->table, $data);
        }
    }
}
