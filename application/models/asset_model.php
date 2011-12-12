<?php

class Asset_model extends Crud {

    public function __construct($data = array()) {
        parent::__construct();

        $this->table = 'assets';
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * @param array $new_asset_array
     * @return array
     */
	public function create_asset($new_asset_array) {
		$query = $this->db->insert($this->table, $new_asset_array);

		if ($query == TRUE) {
			$data['is_true'] = TRUE;
			$data['message'] = 'A new asset has been successfully created.';
			return $data;
		} else {
			$data['is_true'] = FALSE;
			$data['message'] = 'Failed to create user! Please try again, if the problem persists, contact a site admin.';
			return $data;
		}
	}
}