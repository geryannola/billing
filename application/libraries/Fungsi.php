<?php
Class Fungsi{
    protected $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }

    public function user_login(){
        $this->ci->load->model('M_user');
        $id_username = $this->ci->session->userdata('id_username');
        $user_data = $this->ci->M_user->get_by_id($id_username)->row();
        return $user_data;
    }
}