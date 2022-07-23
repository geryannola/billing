<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kas_keluar extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('Kas_keluar_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));

        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/kas_keluar/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/kas_keluar/index/';
            $config['first_url'] = base_url() . 'index.php/kas_keluar/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Kas_keluar_model->total_rows($q);
        $kas_keluar = $this->Kas_keluar_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kas_keluar_data' => $kas_keluar,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template', 'kas_keluar/kas_keluar_list', $data);
    }

    public function read($id)
    {
        $row = $this->Kas_keluar_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_km' => $row->id_km,
                'tgl_km' => $row->tgl_km,
                'uraian_km' => $row->uraian_km,
                'keluar' => $row->keluar,
            );
            $this->template->load('template', 'kas_keluar/kas_keluar_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kas_keluar'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kas_keluar/create_action'),
            'id_km' => set_value('id_km'),
            'tgl_km' => set_value('tgl_km'),
            'uraian_km' => set_value('uraian_km'),
            // 'masuk' => set_value('masuk'),
            'keluar' => set_value('keluar'),
            // 'jenis' => set_value('jenis'),
        );
        $this->template->load('template', 'kas_keluar/kas_keluar_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'tgl_km' => $this->input->post('tgl_km', TRUE),
                'uraian_km' => $this->input->post('uraian_km', TRUE),
                'masuk' => 0,
                'keluar' => $this->input->post('keluar', TRUE),
                'jenis' => 'Keluar',
            );

            $this->Kas_keluar_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('kas_keluar'));
        }
    }

    public function update($id)
    {
        $row = $this->Kas_keluar_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kas_keluar/update_action'),
                'id_km' => set_value('id_km', $row->id_km),
                'tgl_km' => set_value('tgl_km', $row->tgl_km),
                'uraian_km' => set_value('uraian_km', $row->uraian_km),
                // 'masuk' => set_value('masuk', $row->masuk),
                'keluar' => set_value('keluar', $row->keluar),
                // 'jenis' => set_value('jenis', $row->jenis),
            );
            $this->template->load('template', 'kas_keluar/kas_keluar_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kas_keluar'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_km', TRUE));
        } else {
            $data = array(
                'tgl_km' => $this->input->post('tgl_km', TRUE),
                'uraian_km' => $this->input->post('uraian_km', TRUE),
                'masuk' => 0,
                'keluar' => $this->input->post('keluar', TRUE),
                'jenis' => 'Keluar',
            );

            $this->Kas_keluar_model->update($this->input->post('id_km', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kas_keluar'));
        }
    }

    public function delete($id)
    {
        $row = $this->Kas_keluar_model->get_by_id($id);

        if ($row) {
            $this->Kas_keluar_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kas_keluar'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kas_keluar'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('tgl_km', 'tgl km', 'trim|required');
        $this->form_validation->set_rules('uraian_km', 'uraian km', 'trim|required');
        // $this->form_validation->set_rules('masuk', 'masuk', 'trim|required');
        $this->form_validation->set_rules('keluar', 'keluar', 'trim|required');
        // $this->form_validation->set_rules('jenis', 'jenis', 'trim|required');

        $this->form_validation->set_rules('id_km', 'id_km', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "kas_keluar.xls";
        $judul = "kas_keluar";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Tgl Km");
        xlsWriteLabel($tablehead, $kolomhead++, "Uraian Km");
        // xlsWriteLabel($tablehead, $kolomhead++, "Masuk");
        xlsWriteLabel($tablehead, $kolomhead++, "Keluar");
        // xlsWriteLabel($tablehead, $kolomhead++, "Jenis");

        foreach ($this->Kas_keluar_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->tgl_km);
            xlsWriteLabel($tablebody, $kolombody++, $data->uraian_km);
            // xlsWriteNumber($tablebody, $kolombody++, $data->masuk);
            xlsWriteNumber($tablebody, $kolombody++, $data->keluar);
            // xlsWriteLabel($tablebody, $kolombody++, $data->jenis);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=kas_keluar.doc");

        $data = array(
            'kas_keluar_data' => $this->Kas_keluar_model->get_all(),
            'start' => 0
        );

        $this->load->view('kas_keluar/kas_masjid_doc', $data);
    }
}

/* End of file kas_keluar.php */
/* Location: ./application/controllers/kas_keluar.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-22 18:09:46 */
/* http://harviacode.com */