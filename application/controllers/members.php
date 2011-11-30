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

            $this->load->model('user_model');

            $result = $this->user_model->create_user($new_user_array);

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
    public function upload() {
        $data['title'] = 'Upload your files | Codeigniter Authentication';

        $this->load->view('layouts/default', $data);
    }


    /**
     *
     * @return void
     */
    public function do_upload() {
        $this->load->library('upload', $this->config->config['upload']);

        print_r($_FILES);
        die();
        

        if (!$this->upload->do_upload())
        {
            $error = array('error' => $this->upload->display_errors());

            //$this->load->view('upload_form', $error);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());

            //$this->load->view('upload_success', $data);
        }

    }

}
