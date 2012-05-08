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
        $default_new_asset_array['uuid'] = String::uuid();
        $default_new_asset_array['owner_id'] = $this->session->userdata('user_id');
        $default_new_asset_array['extension'] = get_file_extension($new_asset_array['name']);
        $default_new_asset_array['status'] = $this->config->item('temp', 'asset_status');
        $default_new_asset_array['created_at'] = date('Y-m-d H:i:s');

        if ($new_asset_array) {
            $new_asset_array = array_replace_recursive($default_new_asset_array, $new_asset_array);
        }

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
     * @param string $asset_uuid
     * @param integer $owner_id
     * @return mixed
     */
    public function check_asset_owner($asset_uuid, $owner_id) {
        return $this->select_all_where(array('uuid' => $asset_uuid, 'owner_id' => $owner_id));
    }
}