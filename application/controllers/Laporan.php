<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Laporan extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }


    public function index() {
        $this->template->load('template', 'laporan/v_laporan');
    }

    public function kas_masjid_full() {
        $this->load->view('laporan/kas_masjid_full');
    }
    public function kas_masjid_per() {
        $this->load->view('laporan/kas_masjid_per');
    }




}
