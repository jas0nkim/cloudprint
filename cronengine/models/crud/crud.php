<?php

class Crud {
    protected $db;
    protected $table;
    protected $columns;

    /**
     * construct
     *
     * @param null $db
     * @param null $table
     * @param null $columns
     */
    public function __construct($db=null, $table=null, $columns=null) {
        $this->db = $db;
        $this->table = $table;
        $this->columns = array();

        if ($columns) {
            $this->columns = array_replace_recursive($this->columns, $columns);
        }
    }

    /**
     * Allows models to access database column values.
     *
     * @param $key
     * @return mixed
     */
    public function __get($key) {
        if (array_key_exists($key, $this->columns)) {
            return $this->columns[$key];
        }
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

}