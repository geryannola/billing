<?php
function check_already_login(){
    $ci =& get_instance();
    $user_session = $ci->session->userdata('username');
    if ($user_session){
        if($ci->session->userdata('is_aktive')==1){
            redirect('home');
        }else{
            
        }
        
    }
}
function check_not_login(){
    $ci =& get_instance();
    $user_session = $ci->session->userdata('username');
    if (!$user_session){
        redirect('login');
    }
}

    function check_admin(){
        $ci =& get_instance();
        $ci->load->library('fungsi');
        if($ci->fungsi->user_login()->id_level !=1 ){
            redirect('home');

        }

    }

    