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
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));

        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/paket/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/paket/index/';
            $config['first_url'] = base_url() . 'index.php/paket/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Paket_model->total_rows($q);
        $paket = $this->Paket_model->get_limit_data($config['per_page'], $start, $q);
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
        $this->template->load('template', 'paket/paket_list', $data);
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
            $this->template->load('template', 'paket/paket_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('paket/create_action'),
            'id_paket' => set_value('id_paket'),
            'nama_paket' => set_value('nama_paket'),
            'harga_paket' => set_value('harga_paket'),
            'limit_paket' => set_value('limit_paket'),
            'is_aktive' => set_value('is_aktive'),
            'create_date' => set_value('create_date'),
        );
        $this->template->load('template', 'paket/paket_form', $data);
    }

    public function create_action()
    {

        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_paket' => $this->input->post('nama_paket', TRUE),
                'harga_paket' => $this->input->post('harga_paket', TRUE),
                'limit_paket' => $this->input->post('limit_paket', TRUE),
                'is_aktive' => $this->input->post('is_aktive', TRUE),
                'create_date' => date('y-m-d H:i:s')
            );

            $this->Paket_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('paket'));
        }
    }

    public function update($id)
    {
        $row = $this->Paket_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('paket/update_action'),
                'id_paket' => set_value('id_paket', $row->id_paket),
                'nama_paket' => set_value('nama_paket', $row->nama_paket),
                'harga_paket' => set_value('harga_paket', $row->harga_paket),
                'limit_paket' => set_value('limit_paket', $row->limit_paket),
                'is_aktive' => set_value('is_aktive', $row->is_aktive),
                'create_date' => set_value('create_date', $row->create_date),
            );
            // $data['coba'] = $this->paket_level_model->tampil_level();
            $data['data_paket'] = $this->Paket_model->edit_data($id);
            $this->template->load('template', 'paket/paket_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket'));
        }
    }

    public function update_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_paket', TRUE));
        } else {
            $data = array(
                'nama_paket' => $this->input->post('nama_paket', TRUE),
                'harga_paket' => $this->input->post('harga_paket', TRUE),
                'limit_paket' => $this->input->post('limit_paket', TRUE),
                'is_aktive' => $this->input->post('is_aktive', TRUE),
            );

            $this->Paket_model->update($this->input->post('id_paket', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('paket'));
        }
    }

    public function delete($id)
    {
        $row = $this->Paket_model->get_by_id($id);

        if ($row) {
            $this->Paket_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('paket'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('paket'));
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