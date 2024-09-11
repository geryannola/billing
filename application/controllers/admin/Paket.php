<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model('Paket_model');
        $this->load->model('Mikrotik_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
         $bisnis = $_SESSION['bisnis'];
        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/admin/paket/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/admin/paket/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/admin/paket/index/';
            $config['first_url'] = base_url() . 'index.php/admin/paket/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Paket_model->total_rows($q, $bisnis);
        $paket = $this->Paket_model->get_limit_data($config['per_page'], $start, $q, $bisnis);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'paket_data' => $paket,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template', 'admin/paket/paket_list', $data);
    }

    public function read($id)
    {
        $row = $this->Paket_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_paket' => $row->id_paket,
                'nama_paket' => $row->nama_paket,
                'harga_paket' => $row->harga_paket,
                'limit_paket' => $row->limit_paket,
                'is_aktive' => $row->is_aktive,
                'create_date' => $row->create_date,
            );
            $this->template->load('template', 'admin/paket/paket_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/paket'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('admin/paket/create_action'),
            'id_paket' => set_value('id_paket'),
            'service' => set_value('service'),
            'profile' => set_value('profile'),
            'nama_paket' => set_value('nama_paket'),
            'harga_paket' => set_value('harga_paket'),
            'limit_paket' => set_value('limit_paket'),
            'is_aktive' => set_value('is_aktive'),
            'create_date' => set_value('create_date'),
        );
        $this->template->load('template', 'admin/paket/paket_form', $data);
    }

    public function create_action()
    {

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $bisnis = $_SESSION['bisnis'];
            $service = $this->input->post('service', TRUE);

            $row = $this->Mikrotik_model->get_by_aktive();
			if ($row) {
				$host = $row->ip_mikrotik;
				$username = $row->user_mikrotik;
				$password = $row->pass_mikrotik;

				$API = new Mikweb();
				if ($API->connect(
					$host,
					$username,
					$password
				)) {
                    if($service == 'hostpot') {
                        $name =  $this->input->post('nama_paket', TRUE);
                        $shared_users =  1;
                        $rate_limit =  $this->input->post('limit_paket', TRUE);
                        $parent_queue =  '2.CLIEN HOTSPOT';
                        // Kirim permintaan untuk menambahkan pengguna hotspot
    
                        $API->comm("/ip/hotspot/user/profile/add", array(
                            /*"add-mac-cookie" => "yes",*/
                            "name" => "$name",
                            "rate-limit" => "$rate_limit",
                            "shared-users" => "$shared_users",
                            "status-autorefresh" => "1m",
                            "transparent-proxy" => "yes",
                            "parent-queue" => "$parent_queue"
                        ));
    
                        $getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
                            "?name" => "$name",
                        ));
                        $pid = $getprofile[0]['.id'];
                        // Tutup koneksi
                        $this->Mikrotik_model->disconnect();
                    } elseif($service =='ppp') {
                        $name =  $this->input->post('nama_paket', TRUE);
                        $local_address =  'IP-PPPoE';
                        $remote_address =  'IP-PPPoE';
                        $rate_limit =  $this->input->post('limit_paket', TRUE);
                        $only_one =  'yes';
                        // Kirim permintaan untuk menambahkan pengguna ppp
    
                        $API->comm("/ppp/profile/add", array(
                            /*"add-mac-cookie" => "yes",*/
                            "name" => "$name",
                            "local-address" => "$local_address",
                            "remote-address" => "$remote_address",
                            "rate-limit" => "$rate_limit",
                            "only-one" => "$only_one",
                        ));
    
                        $getprofile = $API->comm("/ppp/profile/print", array(
                            "?name" => "$name",
                        ));
                        $pid = $getprofile[0]['.id'];
                        // Tutup koneksi
                        $this->Mikrotik_model->disconnect();
                    }
                    $data = array(
                        'nama_paket' => $this->input->post('nama_paket', TRUE),
                        'service' => $this->input->post('service', TRUE),
                        'profile' => str_replace("*", '', $pid),
                        'harga_paket' => $this->input->post('harga_paket', TRUE),
                        'limit_paket' => $this->input->post('limit_paket', TRUE),
                        'id_bisnis' => $bisnis,
                        'id_mikrotik' => $row->id_mikrotik,
                        'is_aktive' => $this->input->post('is_aktive', TRUE),
                        'create_date' => date('y-m-d H:i:s')
                    );
        
                    $this->Paket_model->insert($data);
                    $this->session->set_flashdata('message', 'Create Record Success');
                    redirect(site_url('admin/paket'));
                } else {
                    redirect(site_url('admin/paket'));
                }
            }            
        }
    }

    public function update($id)
    {
        $row = $this->Paket_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('admin/paket/update_action'),
                'id_paket' => set_value('id_paket', $row->id_paket),
                'nama_paket' => set_value('nama_paket', $row->nama_paket),
                'service' => set_value('service', $row->service),
                'profile' => set_value('profile', $row->profile),
                'harga_paket' => set_value('harga_paket', $row->harga_paket),
                'limit_paket' => set_value('limit_paket', $row->limit_paket),
                'is_aktive' => set_value('is_aktive', $row->is_aktive),
                'create_date' => set_value('create_date', $row->create_date),
            );
            // $data['coba'] = $this->paket_level_model->tampil_level();
            $data['data_paket'] = $this->Paket_model->edit_data($id);
            $this->template->load('template', 'admin/paket/paket_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/paket'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_paket', TRUE));
        } else {
            $service = $this->input->post('service', TRUE);

            $row = $this->Mikrotik_model->get_by_aktive();
			if ($row) {
				$host = $row->ip_mikrotik;
				$username = $row->user_mikrotik;
				$password = $row->pass_mikrotik;

				$API = new Mikweb();
				if ($API->connect(
					$host,
					$username,
					$password
				)) {
                    if($service == 'hostpot') {
                        $profile =  "*".$this->input->post('profile', TRUE);
                        $name =  $this->input->post('nama_paket', TRUE);
                        $shared_users =  1;
                        $rate_limit =  $this->input->post('limit_paket', TRUE);
                        $parent_queue =  '2.CLIEN HOTSPOT';
                        // Kirim permintaan untuk menambahkan pengguna hotspot
    
                        $API->comm("/ip/hotspot/user/profile/set", array(
                            /*"add-mac-cookie" => "yes",*/
                             ".id" => "$profile",
                            "name" => "$name",
                            "rate-limit" => "$rate_limit",
                            "shared-users" => "$shared_users",
                            "status-autorefresh" => "1m",
                            "transparent-proxy" => "yes",
                            "parent-queue" => "$parent_queue"
                        ));
    
                        $getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
                            "?name" => "$name",
                        ));
                        $pid = $getprofile[0]['.id'];
                        // Tutup koneksi
                        $this->Mikrotik_model->disconnect();
                    } elseif($service == 'ppp') {
                        $profile =  "*".$this->input->post('profile', TRUE);
                        $name =  $this->input->post('nama_paket', TRUE);
                        $local_address =  'IP-PPPoE';
                        $remote_address =  'IP-PPPoE';
                        $rate_limit =  $this->input->post('limit_paket', TRUE);
                        $only_one =  'yes';
                        // Kirim permintaan untuk menambahkan pengguna ppp
                        $API->comm("/ppp/profile/set", array(
                            /*"add-mac-cookie" => "yes",*/
                            ".id" => "$profile",
                            "name" => "$name",
                            "local-address" => "$local_address",
                            "remote-address" => "$remote_address",
                            "rate-limit" => "$rate_limit",
                            "only-one" => "$only_one",
                        ));
    
                        $getprofile = $API->comm("/ppp/profile/print", array(
                            "?name" => "$name",
                        ));
                        $pid = $getprofile[0]['.id'];
                        // Tutup koneksi
                        $this->Mikrotik_model->disconnect();
                    }
                    $data = array(
                        'nama_paket' => $this->input->post('nama_paket', TRUE),
                        'service' => $this->input->post('service', TRUE),
                        'profile' => $this->input->post('profile', TRUE),
                        'harga_paket' => $this->input->post('harga_paket', TRUE),
                        'limit_paket' => $this->input->post('limit_paket', TRUE),
                        'is_aktive' => $this->input->post('is_aktive', TRUE),
                    );
        
                    $this->Paket_model->update($this->input->post('id_paket', TRUE), $data);
                    $this->session->set_flashdata('message', 'Update Record Success');
                    redirect(site_url('admin/paket'));
                }else {
                    $this->session->set_flashdata('message', 'Update Record Gagal');
                    redirect(site_url('admin/paket'));

                }
            }
        }
    }

    public function delete($id)
    {
        $row = $this->Paket_model->get_by_id($id);
        if ($row) {
            $service = $row->service;
            $rowMikrotik = $this->Mikrotik_model->get_by_aktive();
			if ($rowMikrotik) {
				$host = $rowMikrotik->ip_mikrotik;
				$username = $rowMikrotik->user_mikrotik;
				$password = $rowMikrotik->pass_mikrotik;

				$API = new Mikweb();
				if ($API->connect(
					$host,
					$username,
					$password
				)) {
                    if($service == 'hostpot') {
                        $profile_id = "*".$row->profile;
                        $API->comm("/ip/hotspot/user/profile/remove", array(
                            ".id" => $profile_id
                        ));
                        // Tutup koneksi
                        $this->Mikrotik_model->disconnect();
                    } elseif($service == 'ppp') {
                        $profile_id = '*'.$row->profile;                        
                        // Kirim permintaan untuk menghapus profil PPP
                        $API->comm("/ppp/profile/remove", array(
                            ".id" => $profile_id
                        ));
                        $this->Mikrotik_model->disconnect();
                    }
                    // var_dump($row);
                    // var_dump($profile_id);
                    // die();
                    $this->Paket_model->delete($id);
                    $this->session->set_flashdata('message', 'Delete Record Success');
                    redirect(site_url('admin/paket'));
                }
            }
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('admin/paket'));
        }
    }

    public function _rules()
    {

        $this->form_validation->set_rules('nama_paket', 'Nama Paket', 'trim|required');
        $this->form_validation->set_rules('harga_paket', 'Harga Paket', 'trim|required');
        $this->form_validation->set_rules('limit_paket', 'Limit Paket', 'trim|required');
        $this->form_validation->set_rules('is_aktive', 'is aktive', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "paket.xls";
        $judul = "paket";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Paket");
        xlsWriteLabel($tablehead, $kolomhead++, "Harga Paket");
        xlsWriteLabel($tablehead, $kolomhead++, "Limit");
        xlsWriteLabel($tablehead, $kolomhead++, "Is Aktive");

        foreach ($this->Paket_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_paket);
            xlsWriteLabel($tablebody, $kolombody++, $data->harga_paket);
            xlsWriteLabel($tablebody, $kolombody++, $data->limit_paket);
            xlsWriteLabel($tablebody, $kolombody++, $data->is_aktive);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=paket.doc");

        $data = array(
            'paket_data' => $this->Paket_model->get_all(),
            'start' => 0
        );

        $this->load->view('paket/paket_doc', $data);
    }
}

/* End of file paket.php */
/* Location: ./application/controllers/paket.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 21:45:15 */
/* http://harviacode.com */