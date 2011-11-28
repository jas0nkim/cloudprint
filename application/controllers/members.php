<?php

class Members extends CI_Controller {

    /**
     * 
     * @return void
     */
    public function login() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[25]|xss_clean|callback__check_username_exist_login');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|max_length[25]|xss_clean');

        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Login | Envysea Codeigniter Authentication';

            $this->load->view('layouts/default', $data);
        } else {
            $result = $this->auth->login($this->input->post('username'), sha1($this->config->item('salty_salt').$this->input->post('password')));

            if ($result['is_true'] == TRUE &&  $result['is_admin'] == TRUE) {
                $this->session->set_flashdata('message', '<div class="success_message">'.$result['message'].'</div>');
                redirect('admin', 'location');
            } elseif ($result['is_true'] == TRUE && $result['is_admin'] == FALSE) {
                $this->session->set_flashdata('message', '<div class="success_message">'.$result['message'].'</div>');
                redirect('secure', 'location');
            } else {
                $data['message'] = '<div class="error_message">'.$result['message'].'</div>';
                $data['title'] = 'Login | Envysea Codeigniter Authentication';


                $this->load->view('layouts/default', $data);
            }

        }

    }

}
