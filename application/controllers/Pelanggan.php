<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelanggan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model('Pelanggan_model');
        $this->load->model('Cabang_model');
        $this->load->model('Paket_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));

        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/pelanggan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/pelanggan/index/';
            $config['first_url'] = base_url() . 'index.php/pelanggan/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Pelanggan_model->total_rows($q);
        $pelanggan = $this->Pelanggan_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pelanggan_data' => $pelanggan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template', 'pelanggan/pelanggan_list', $data);
    }

    public function read($id)
    {
        $row = $this->Pelanggan_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_pelanggan' => $row->id_pelanggan,
                'nama_pelanggan' => $row->nama_pelanggan,
                'alamat' => $row->alamat,
                'no_wa' => $row->no_wa,
                'ip' => $row->ip,
                'username' => $row->username,
                'password' => $row->password,
                'r_wifi' => $row->r_wifi,
                'r_password' => $row->r_password,
                'tgl_mulai' => $row->tgl_mulai,
                'cabang' => $row->cabang,
                'nama_paket' => $row->cabang,
            );
            $this->template->load('template', 'pelanggan/pelanggan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('pelanggan/create_action'),
            'id_pelanggan' => set_value('id_pelanggan'),
            'nama_pelanggan' => set_value('nama_pelanggan'),
            'alamat' => set_value('alamat'),
            'no_wa' => set_value('no_wa'),
            'ip' => set_value('ip'),
            'username' => set_value('username'),
            'password' => set_value('password'),
            'r_wifi' => set_value('r_ifi'),
            'r_password' => set_value('r_password'),
            'tgl_mulai' => set_value('tgl_mulai'),
            'id_cabang' => set_value('id_cabang'),
        );
        $data['cabang'] = $this->Cabang_model->tampil_cabang();
        $data['paket'] = $this->Paket_model->tampil_paket();
        $this->template->load('template', 'pelanggan/pelanggan_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_pelanggan' => $this->input->post('nama_pelanggan', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_wa' => $this->input->post('no_wa', TRUE),
                'ip' => $this->input->post('ip', TRUE),
                'username' => $this->input->post('username', TRUE),
                'password' => $this->input->post('password', TRUE),
                'r_wifi' => $this->input->post('r_wifi', TRUE),
                'r_password' => $this->input->post('r_password', TRUE),
                'tgl_mulai' => $this->input->post('tgl_mulai', TRUE),
                'id_cabang' => $this->input->post('id_cabang', TRUE),
                'id_paket' => $this->input->post('id_paket', TRUE),
                'is_aktive' => $this->input->post('is_aktive', TRUE),
                'create_date' => date('y-m-d H:i:s')
            );

            $this->Pelanggan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('pelanggan'));
        }
    }

    public function update($id)
    {
        $row = $this->Pelanggan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pelanggan/update_action'),
                'id_pelanggan' => set_value('id_pelanggan', $row->id_pelanggan),
                'nama_pelanggan' => set_value('nama_pelanggan', $row->nama_pelanggan),
                'alamat' => set_value('alamat', $row->alamat),
                'no_wa' => set_value('no_wa', $row->no_wa),
                'ip' => set_value('ip', $row->ip),
                'username' => set_value('username', $row->username),
                'password' => set_value('password', $row->password),
                'r_wifi' => set_value('r_wifi', $row->r_wifi),
                'r_password' => set_value('r_password', $row->r_password),
                'tgl_mulai' => set_value('tgl_mulai', $row->tgl_mulai),
                'id_cabang' => set_value('id_cabang', $row->id_cabang),
                'id_paket' => set_value('id_paket', $row->id_paket),
                'is_aktive' => set_value('is_aktive', $row->is_aktive),
            );
            $data['cabang'] = $this->Cabang_model->tampil_cabang();
            $data['paket'] = $this->Paket_model->tampil_paket();
            $data['data_pelanggan'] = $this->Pelanggan_model->edit_data($id);

            $this->template->load('template', 'pelanggan/pelanggan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pelanggan', TRUE));
        } else {
            $data = array(
                'nama_pelanggan' => $this->input->post('nama_pelanggan', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_wa' => $this->input->post('no_wa', TRUE),
                'ip' => $this->input->post('ip', TRUE),
                'username' => $this->input->post('username', TRUE),
                'password' => $this->input->post('password', TRUE),
                'r_wifi' => $this->input->post('r_wifi', TRUE),
                'r_password' => $this->input->post('r_password', TRUE),
                'id_cabang' => $this->input->post('id_cabang', TRUE),
                'id_paket' => $this->input->post('id_paket', TRUE),
                'tgl_mulai' => $this->input->post('tgl_mulai', TRUE),
                'is_aktive' => $this->input->post('is_aktive', TRUE),
            );

            $this->Pelanggan_model->update($this->input->post('id_pelanggan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('pelanggan'));
        }
    }

    public function delete($id)
    {
        $row = $this->Pelanggan_model->get_by_id($id);

        if ($row) {
            $this->Pelanggan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('pelanggan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('pelanggan'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_pelanggan', 'Nama Pelanggan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_wa', 'No WA', 'trim|required');
        $this->form_validation->set_rules('ip', 'IP Pelanggan', 'trim|required');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('r_wifi', 'Nama Wifi', 'trim|required');
        $this->form_validation->set_rules('r_password', 'Password Wifi', 'trim|required');
        $this->form_validation->set_rules('tgl_mulai', 'Tanggal Mulai', 'trim|required');
        $this->form_validation->set_rules('id_cabang', 'Cabang', 'trim|required');
        $this->form_validation->set_rules('id_paket', 'Paket', 'trim|required');

        $this->form_validation->set_rules('id_pelanggan', 'id_pelanggan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "pelanggan.xls";
        $judul = "pelanggan";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Pelanggan");
        xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
        xlsWriteLabel($tablehead, $kolomhead++, "IP");
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Wifi");
        xlsWriteLabel($tablehead, $kolomhead++, "Password");
        xlsWriteLabel($tablehead, $kolomhead++, "Tgl Mulai");

        foreach ($this->Pelanggan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_pelanggan);
            xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
            xlsWriteLabel($tablebody, $kolombody++, $data->ip);
            xlsWriteLabel($tablebody, $kolombody++, $data->wifi);
            xlsWriteLabel($tablebody, $kolombody++, $data->password);
            xlsWriteLabel($tablebody, $kolombody++, $data->tgl_mulai);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=pelanggan.doc");

        $data = array(
            'pelanggan_data' => $this->Pelanggan_model->get_all(),
            'start' => 0
        );

        $this->load->view('pelanggan/pelanggan_doc', $data);
    }
}

/* End of file pelanggan.php */
/* Location: ./application/controllers/pelanggan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 18:40:20 */
/* http://harviacode.com */