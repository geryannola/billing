<?php

defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Laporan extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('Kas_keluar_model');
        $this->load->model('Kas_masuk_model');
        $this->load->model('Rekap_kas_model');
        $this->load->library('form_validation');
    }


    public function index()
    {
        $this->template->load('template', 'laporan/v_laporan');
    }

    public function kas_full()
    {
        $total_masuk = $this->Kas_masuk_model->total_masuk();
        $total_keluar = $this->Kas_keluar_model->total_keluar();
        $data = array(
            'kas_data' => $this->Rekap_kas_model->get_all(),
            'total_masuk' => set_value('total_masuk', $total_masuk->masuk),
            'total_keluar' => set_value('total_keluar', $total_keluar->keluar),
        );
        $this->load->view('laporan/kas_full', $data);
    }
    public function kas_per()
    {

        $tgl_1 = $this->input->post('tgl_1');
        $tgl_2 = $this->input->post('tgl_2');
        $total_masuk = $this->Kas_masuk_model->total_masuk_per($tgl_1, $tgl_2);
        $total_keluar = $this->Kas_keluar_model->total_keluar_per($tgl_1, $tgl_2);
        $data = array(
            'kas_data' => $this->Rekap_kas_model->get_per($tgl_1, $tgl_2),
            'total_masuk' => set_value('total_masuk', $total_masuk->masuk),
            'total_keluar' => set_value('total_keluar', $total_keluar->keluar),
            'tgl_1' => $tgl_1,
            'tgl_2' => $tgl_2,
        );
        $this->load->view('laporan/kas_per', $data);
    }
}
