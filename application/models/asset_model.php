<?php

class Asset_model extends Crud {

    /**
     * @param null $columns
     */
    public function __construct($columns=null) {
        $this->table = 'assets';
        parent::__construct($columns);
    }

    /**
     * @param array $new_asset_array
     * @return array
     */
	public function create_asset($new_asset_array) {
        $new_asset_array['uuid'] = String::uuid();
        $new_asset_array['extension'] = Asset_model::get_file_extension($new_asset_array['name']);
        $new_asset_array['status'] = $this->config->item('temp', 'asset_status');
        $new_asset_array['created_at'] = date('Y-m-d H:i:s');

		$query = $this->insert_entry($new_asset_array);

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

    /**
     * @static
     * @param string $file_name
     * @return string
     */
    public static function get_file_extension($file_name) {
        return strtolower(substr(strrchr($file_name,'.'),1));
    }

}