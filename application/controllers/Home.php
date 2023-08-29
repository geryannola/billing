<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('Home_model');
        $this->load->model('Whatsapp_model');
    }


    public function index()
    {

        $total = $this->Home_model->total();
        $abc = $this->Home_model->total_abc();
        $kassi = $this->Home_model->total_kassi();
        $data_wa = array(
            'url' => whatsapp_url(),
            'link' => "/",
        );

        $status = $this->Whatsapp_model->whatsapp_status($data_wa);
        $status = (json_decode($status, true));
        if ($status != NULL) {
            $status = $status['data'];
        } else {
            $status = 'Tidak terkoneksi, Mohon Cek WhatsApp Gateway';
        }
        $data = array(
            'total' => set_value('total', $total),
            'abc' => set_value('abc', $abc),
            'kassi' => set_value('kassi', $kassi),
            'status' => set_value('status', $status),
        );
        $this->template->load('template', 'welcome', $data);
    }
}
