<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class Home extends CI_Controller {

    function __construct()
    {
        parent::__construct();
    }


    public function index() {
        $this->template->load('template', 'welcome');
    }


}
