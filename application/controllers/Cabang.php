<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cabang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        check_admin();
        $this->load->model('Cabang_model');
        $this->load->library('form_validation');
        // $this->load->model('cabang_model');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));

        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/cabang/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/cabang/index/';
            $config['first_url'] = base_url() . 'index.php/cabang/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Cabang_model->total_rows($q);
        $cabang = $this->Cabang_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'cabang_data' => $cabang,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template', 'cabang/cabang_list', $data);
    }

    public function read($id)
    {
        $row = $this->Cabang_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_cabang' => $row->id_cabang,
                'cabang' => $row->cabang,
                'alamat' => $row->alamat,
                'user_mikrotik' => $row->user_mikrotik,
                'pass_mikrotik' => $row->pass_mikrotik,
                'ip_mikrotik' => $row->ip_mikrotik,
                'domain' => $row->domain,
                'is_aktive' => $row->is_aktive,
                'create_date' => $row->create_date,
            );
            $this->template->load('template', 'cabang/cabang_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cabang'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('cabang/create_action'),
            'id_cabang' => set_value('id_cabang'),
            'cabang' => set_value('cabang'),
            'alamat' => set_value('alamat'),
            'user_mikrotik' => set_value('user_mikrotik'),
            'pass_mikrotik' => set_value('pass_mikrotik'),
            'ip_mikrotik' => set_value('ip_mikrotik'),
            'domain' => set_value('domain'),
            'is_aktive' => set_value('is_aktive'),
            'create_date' => set_value('create_date'),
        );
        // $data['coba'] = $this->cabang_level_model->tampil_level();
        $this->template->load('template', 'cabang/cabang_form', $data);
    }

    public function create_action()
    {

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'cabang' => $this->input->post('cabang', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'user_mikrotik' => $this->input->post('user_mikrotik', TRUE),
                'pass_mikrotik' => $this->input->post('pass_mikrotik', TRUE),
                'ip_mikrotik' => $this->input->post('ip_mikrotik', TRUE),
                'domain' => $this->input->post('domain', TRUE),
                'is_aktive' => $this->input->post('is_aktive', TRUE),
                'create_date' => date('y-m-d H:i:s')
            );

            $this->Cabang_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('cabang'));
        }
    }

    public function update($id)
    {
        $row = $this->Cabang_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('cabang/update_action'),
                'id_cabang' => set_value('id_cabang', $row->id_cabang),
                'cabang' => set_value('cabang', $row->cabang),
                'alamat' => set_value('alamat', $row->alamat),
                'user_mikrotik' => set_value('user_mikrotik', $row->user_mikrotik),
                'pass_mikrotik' => set_value('pass_mikrotik', $row->pass_mikrotik),
                'ip_mikrotik' => set_value('ip_mikrotik', $row->ip_mikrotik),
                'domain' => set_value('domain', $row->domain),
                'is_aktive' => set_value('is_aktive', $row->is_aktive),
                'create_date' => set_value('create_date', $row->create_date),
            );
            // $data['coba'] = $this->cabang_level_model->tampil_level();
            $data['data_cabang'] = $this->Cabang_model->edit_data($id);
            $this->template->load('template', 'cabang/cabang_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cabang'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_cabang', TRUE));
        } else {
            $data = array(
                'cabang' => $this->input->post('cabang', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'user_mikrotik' => $this->input->post('user_mikrotik', TRUE),
                'pass_mikrotik' => $this->input->post('pass_mikrotik', TRUE),
                'ip_mikrotik' => $this->input->post('ip_mikrotik', TRUE),
                'domain' => $this->input->post('domain', TRUE),
                'is_aktive' => $this->input->post('is_aktive', TRUE),
            );


            $this->Cabang_model->update($this->input->post('id_cabang', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('cabang'));
        }
    }

    public function delete($id)
    {
        $row = $this->Cabang_model->get_by_id($id);

        if ($row) {
            $this->Cabang_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('cabang'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('cabang'));
        }
    }

    public function _rules()
    {

        $this->form_validation->set_rules('cabang', 'cabang', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('user_mikrotik', 'user_mikrotik', 'trim|required');
        $this->form_validation->set_rules('pass_mikrotik', 'pass_mikrotik', 'trim|required');
        $this->form_validation->set_rules('ip_mikrotik', 'ip_mikrotik', 'trim|required');
        $this->form_validation->set_rules('domain', 'domain', 'trim|required');
        $this->form_validation->set_rules('is_aktive', 'is aktive', 'trim|required');

        // $this->form_validation->set_rules('id_username', 'id_username', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "cabang.xls";
        $judul = "cabang";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Cabang");
        xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
        xlsWriteLabel($tablehead, $kolomhead++, "User Mikrotik");
        xlsWriteLabel($tablehead, $kolomhead++, "Password Mikrotik");
        xlsWriteLabel($tablehead, $kolomhead++, "Ip Mikrotik");
        xlsWriteLabel($tablehead, $kolomhead++, "Domain");
        xlsWriteLabel($tablehead, $kolomhead++, "Is Aktive");
        xlsWriteLabel($tablehead, $kolomhead++, "Create Date");

        foreach ($this->Cabang_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->cabang);
            xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
            xlsWriteLabel($tablebody, $kolombody++, $data->user_mikrotik);
            xlsWriteLabel($tablebody, $kolombody++, $data->pass_mikrotik);
            xlsWriteLabel($tablebody, $kolombody++, $data->ip_mikrotik);
            xlsWriteLabel($tablebody, $kolombody++, $data->domain);
            xlsWriteLabel($tablebody, $kolombody++, $data->is_aktive);
            xlsWriteLabel($tablebody, $kolombody++, $data->create_date);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=cabang.doc");

        $data = array(
            'cabang_data' => $this->Cabang_model->get_all(),
            'start' => 0
        );

        $this->load->view('cabang/cabang_doc', $data);
    }
}

/* End of file cabang.php */
/* Location: ./application/controllers/cabang.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 21:45:15 */
/* http://harviacode.com */