<?php

class Members extends CI_Controller {

    function __construct() {
        parent::__construct();

        if ($this->router->fetch_method() == 'login') {
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
    function index() {
        $data['title'] = 'You are logged in | Codeigniter Authentication';

        $this->load->view('layouts/default', $data);
    }



}
