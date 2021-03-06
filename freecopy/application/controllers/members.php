<?php

class Members extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->router->fetch_method() == 'login' || $this->router->fetch_method() == 'register') {
            if ($this->auth->is_logged_in()) {
                redirect('members', 'location');
            }
        } else {
            $this->auth->is_logged_in_redirect();
        }
    }

    /**
     *
     * @return void
     */
    public function login() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[25]|xss_clean|callback__check_username_exist_login');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[25]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/default');
            
        } else {
            $result = $this->auth->login($this->input->post('username'), sha1($this->config->item('salty_salt').$this->input->post('password')));

            if ($result['is_true'] == TRUE) {
                $this->session->set_flashdata('message', '<div class="success_message">'.$result['message'].'</div>');
                redirect('members');
            } else {
                $data['message'] = '<div class="error_message">'.$result['message'].'</div>';
                $data['title'] = 'Login | Envysea Codeigniter Authentication';

                $this->load->view('layouts/default', $data);
            }

        }

    }

    /**
     *
     * @return void
     */
    public function logout() {
        $this->auth->logout();

        echo $this->auth->is_logged_in();

        $data['message'] = '<div class="success_message">You have been successfully logged out!</div>';
        $data['title'] = 'Logged Out! | Codeigniter Authentication';
        $data['controller'] = 'members';
        $data['action'] = 'login';

        $this->load->view('layouts/default', $data);

    }

    /**
     * 
     * @return void
     */
    public function index() {
        $data['title'] = 'You are logged in | Codeigniter Authentication';

        $this->load->view('layouts/default', $data);
    }

    /**
     *
     * @return void
     */
    public function register() {
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[4]|max_length[25]|xss_clean|alpha_numeric|callback__check_username_exist_create');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|max_length[200]|xss_clean|valid_email|callback__check_email_exist_create');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[25]|xss_clean|matches[confirm_password]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|min_length[6]|max_length[25]|xss_clean');
        $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|max_length[25]|xss_clean|alpha');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required|trim|max_length[25]|xss_clean|alpha');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Create User | Envysea Codeigniter Authentication';

            $this->load->view('layouts/default', $data);

        } else {

            $new_user_array = array(
                                'username' => $this->input->post('username'),
                                'email' => $this->input->post('email'),
                                'password' => sha1($this->config->item('salty_salt').$this->input->post('password')),
                                'first_name' => $this->input->post('first_name'),
                                'last_name' => $this->input->post('last_name')
                                );

            $this->load->model('User_model');

            $result = $this->User_model->create_user($new_user_array);

            if ($result['is_true'] == TRUE) {
                $this->session->set_flashdata('message', '<div class="success_message">'.$result['message'].'</div>');

                redirect('/', 'location');

            } else {
                $data['message'] = '<div class="error_message">'.$result['message'].'</div>';
                $data['title'] = 'Create User | Codeigniter Authentication';

                $this->load->view('layouts/default', $data);
            }
        }
    }

    /**
     *
     * @return void
     */
    public function free_print() {
        $this->load->model('Printer_model');
        $printers = $this->Printer_model->list_printers();

        $data['title'] = 'Print your documents now | Codeigniter Authentication';
        $data['content_data']['printers'] = $printers;

        $this->load->view('layouts/default', $data);
    }

    /**
     *
     * @return void
     */
    public function upload() {
        $options = $this->config->item('local_upload');
        $options['uuid'] = String::uuid();
        $this->load->library('uploader', $options);

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $info = $this->uploader->get();
                echo Uploader::encode_json_get($info);
                break;
            case 'POST':
                $info = $this->uploader->post();
                foreach($info as $key => $new_asset_array) {
                    if (!isset($new_asset_array['error'])) {
                        if (isset($new_asset_array['delete_type'])) unset($new_asset_array['delete_type']);
                        if (isset($new_asset_array['delete_url'])) unset($new_asset_array['delete_url']);
                        $new_asset_array['stored_name'] = basename($new_asset_array['url']);
                        $this->load->model('Asset_model');
                        $this->Asset_model->create_asset($new_asset_array);
                    }
                }
                echo Uploader::encode_json_post($info);
                break;
            case 'DELETE':
                $this->load->model('Asset_model');
                $asset_info = $this->Asset_model->check_asset_owner($_GET['file'], $this->session->userdata('user_id'));
                if ($asset_info) {
                    $asset_info = $asset_info[0];
                    $is_deleted = $this->uploader->delete($asset_info->stored_name);
                    if ($is_deleted) {
                        $this->Asset_model->delete_entry(array('uuid' => $_GET['file'], 'owner_id' => $this->session->userdata('user_id'))); // have to enter owner_id here
                        echo Uploader::encode_json_get(array('uuid' => $_GET['file']));
                    }
                }
                break;
            default:
                echo json_encode(array('success' => FALSE));
        }
    }

    /**
     * 
     * @return void
     */
    public function file_delete() {
        $options = $this->config->item('local_upload');
        $this->load->library('uploader', $options);
        
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'DELETE':
                $this->load->model('Asset_model');
                $asset_info = $this->Asset_model->check_asset_owner($_GET['file'], $this->session->userdata('user_id'));
                if ($asset_info) {
                    $asset_info = $asset_info[0];
                    $is_deleted = $this->uploader->delete($asset_info->stored_name);
                    if ($is_deleted) {
                        $this->Asset_model->delete_entry(array('uuid' => $_GET['file'], 'owner_id' => $this->session->userdata('user_id'))); // have to enter owner_id here
                        echo Uploader::encode_json_get(array('uuid' => $_GET['file']));
                    }
                }
                break;
            default:
                echo json_encode(array('success' => FALSE));
        }
    }

    /**
     *
     * @return bool
     */
    public function submit_print_job() {
        $gcp = $this->init_gcp();
        $this->load->model('Gcp_printer_model');
        $result = $this->Gcp_printer_model->select_one_where(array('printer_id' => $_POST['printer']));
        $gcp_printer = $result[0];
        $uploaded_uuids = explode(",", $_POST['uploadedfiles']);

        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
        $this->load->model('Asset_model');
        foreach ($uploaded_uuids as $uploaded_uuid) {
            $asset_info = $this->Asset_model->check_asset_owner($uploaded_uuid, $this->session->userdata('user_id'));
            if (!$asset_info) {
                return FALSE;
            }
            $asset_info = $asset_info[0];
            $uploaded_file = $asset_info->stored_name;
            $file_path = $this->config->item('upload_dir', 'local_upload') . $uploaded_file;
            $content_type = finfo_file($finfo, $file_path);

            if (($converted_file = $this->check_convertable_file($uploaded_file, $content_type)) !== FALSE) {
                $file_path = $converted_file->path;
                $content_type = $converted_file->content_type;
            }

            // check number of pages
            echo "page numbers: ".$this->count_page_numbers($file_path);

            //echo $gcp->simple_submit($gcp_printer->printerid, $gcp_printer->capabilities, $file_path, $content_type);
        }
        finfo_close($finfo);
        return TRUE;
    }

    /**
     * @param string $file_name
     * @param $content_type
     * @return bool | string converted file path
     */
    private function check_convertable_file($file_name, $content_type) {
        if (!preg_match($this->config->item('convert_file_mime_types', 'local_file_conv'), $content_type)) {
            return FALSE;
        } else {
            $part_file_name = pathinfo($file_name);
            $config['doc_file_name'] = $file_name;
            $config['pdf_file_name'] = $part_file_name['filename'].'.pdf';
            $config = array_replace_recursive($config, $this->config->item('local_file_conv'));

            try {
                $this->load->library('fileconvertor', $config);
                $ret = new stdClass();
                $ret->path = $this->fileconvertor->convert_doc_to_pdf();
                $ret->content_type = $this->fileconvertor->get_converted_content_type();
                return $ret;

            } catch (Exception $e) {
                error_log($e->getMessage());
                return FALSE;
            }
        }
    }

    private function count_page_numbers($file_path) {
        return shell_exec("identify -format %n ".$file_path);
    }

    /**
     * @return GoogleCloudPrint
     */
    private function init_gcp() {
        $options = array(
            'company_name' => $this->config->item('company_name'),
            'email' => $this->config->item('email', 'gcp'),
            'password' => $this->config->item('password', 'gcp')
        );
        require_once GCPPATH . 'gcp.sdk.php';
        return new GoogleCloudPrint($options);
    }


/**
 * -----------------------------------------------------------------------------------
 * Test GCP Interfaces
 * -----------------------------------------------------------------------------------
 */
    public function test_gcp_search() {
        $gcp = $this->init_gcp();
        echo $gcp->search();
    }

    public function test_gcp_printer() {
        $gcp = $this->init_gcp();
        $printer_id = '7189ce1f-4f61-cc02-22be-e73cf9e51954';
        echo $gcp->printer($printer_id);
    }

    public function test_gcp_jobs() {
        $gcp = $this->init_gcp();
        $printer_id = '7189ce1f-4f61-cc02-22be-e73cf9e51954';
        echo $gcp->jobs($printer_id);
    }

    public function test_gcp_submit() {
        $this->load->model('Gcp_printer_model');
        $conditions = array('printerid' => '7189ce1f-4f61-cc02-22be-e73cf9e51954');
        $result = $this->Gcp_printer_model->select_one_where($conditions);

        foreach ($result as $row) {
            $gcp = $this->init_gcp();
            $printer_id = $row->printerid;
            $title = 'jason test print';
            $capabilities = $row->capabilities;
            $content = 'http://www.google.com';
            $content_type = 'url';
            $tag = '';
            echo $gcp->submit($printer_id, $title, $capabilities, $content, $content_type, $tag);
        }
    }

/**
 * -----------------------------------------------------------------------------------
 * Test LiveDocx
 * -----------------------------------------------------------------------------------
 */
    public function test_count_doc() {
        $livedocx_username = $this->config->item('username', 'livedocx');
        $livedocx_password = $this->config->item('password', 'livedocx');

        echo "LiveDocx Username: ".$livedocx_username."<br><br>";
        echo "LiveDocx Password: ".$livedocx_password."<br><br>";

        $options = array(
            'livedocx_username' => $livedocx_username,
            'livedocx_password' => $livedocx_password,
        );
        $this->load->library('docvalidator', $options);
        echo $this->docvalidator->get_page_count('/home/dev/www/publicweb/webroot/uploads/test_01.doc');

    }

}

/* End of file members.php */