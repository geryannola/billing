<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tagihan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('Tagihan_model');
        $this->load->model('kas_masuk_model');
        $this->load->model('Pelanggan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));

        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/tagihan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/tagihan/index/';
            $config['first_url'] = base_url() . 'index.php/tagihan/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Tagihan_model->total_rows($q, 'N');
        $tagihan = $this->Tagihan_model->get_limit_data($config['per_page'], $start, $q, 'N');
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'tagihan_data' => $tagihan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template', 'tagihan/tagihan_list', $data);
    }

    public function read($id)
    {
        $row = $this->Tagihan_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_pelanggan' => $row->id_pelanggan,
                'nama_bulan' => $row->nama_bulan,
                'tahun' => $row->tahun,
                'status_bayar' => $row->status_bayar,
                'harga_paket' => $row->harga_paket,
                'id_cara_bayar' => $row->id_cara_bayar,
                'tgl_bayar' => $row->tgl_bayar,
            );
            $this->template->load('template', 'tagihan/tagihan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tagihan'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('tagihan/create_action'),
            'id_tagihan' => set_value('id_tagihan'),
            'id_pelanggan' => set_value('id_pelanggan'),
            'bulan' => set_value('bulan'),
            'tahun' => set_value('tahun'),
        );
        $data['pelanggan'] = $this->Pelanggan_model->tampil_pelanggan();
        $data['bulan'] = $this->Tagihan_model->tampil_bulan();
        $data['tahun'] = $this->Tagihan_model->tampil_tahun();
        $this->template->load('template', 'tagihan/tagihan_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        var_dump($this->form_validation->run());
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $id_pelanggan = $this->input->post('id_pelanggan');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $sql = $this->db->query("SELECT id_pelanggan FROM tagihan where id_pelanggan='$id_pelanggan' AND bulan='$bulan' AND tahun='$tahun'");
            $cek_tagihan = $sql->num_rows();

            if ($cek_tagihan > 0) {
                $this->session->set_flashdata('message', 'Data ada sudah ada');
                redirect(site_url('tagihan'));
            } else {
                //insert db
                $data = array(
                    'id_pelanggan' => $this->input->post('id_pelanggan', TRUE),
                    'bulan' => $this->input->post('bulan', TRUE),
                    'tahun' => $this->input->post('tahun', TRUE),
                    'status_bayar' => 'N',
                    'id_cara_bayar' => 1,
                    'tgl_bayar' => '0000 - 00 - 00',
                    'create_date' => date('y-m-d H:i:s')
                );
                $this->Tagihan_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('tagihan'));
            }
        }
    }

    public function delete($id)
    {
        $row = $this->Tagihan_model->get_by_id($id);

        if ($row) {
            $this->Tagihan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('tagihan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tagihan'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'trim|required');
        $this->form_validation->set_rules('bulan', 'Bulan', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');

        $this->form_validation->set_rules('id_tagihan', 'id_tagihan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules_bayar()
    {
        $this->form_validation->set_rules('id_cara_bayar', 'Cara Bayar', 'trim|required');
        $this->form_validation->set_rules('tgl_bayar', 'Tanggal Bayar', 'trim|required');

        $this->form_validation->set_rules('id_tagihan', 'id_tagihan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function bayar($id)
    {
        $row = $this->Tagihan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Bayar',
                'action' => site_url('tagihan/bayar_action'),
                'id_tagihan' => set_value('id_tagihan', $row->id_tagihan),
                'nama_pelanggan' => set_value('nama_pelanggan', $row->nama_pelanggan),
                'harga_paket' => set_value('harga_paket', $row->harga_paket),
                'bulan' => set_value('bulan', $row->bulan),
                'nama_bulan' => set_value('bulan', $row->nama_bulan),
                'alamat' => set_value('tahun', $row->tahun),
                'tahun' => set_value('tahun', $row->tahun),
                'tgl_bayar' => set_value('tgl_bayar', $row->tgl_bayar),
                'id_cara_bayar' => set_value('id_cara_bayar', $row->id_cara_bayar),
            );
            // $data['cabang'] = $this->Cabang_model->tampil_cabang();
            $data['cara_bayar'] = $this->Tagihan_model->tampil_bayar();
            $data['data_pelanggan'] = $this->Tagihan_model->edit_data($id);

            $this->template->load('template', 'tagihan/tagihan_bayar', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('tagihan'));
        }
    }
    public function bayar_action()
    {
        $this->_rules_bayar();
        if ($this->form_validation->run() == FALSE) {
            $this->bayar($this->input->post('id_tagihan', TRUE));
        } else {
            $nama_pelanggan = $this->input->post('nama_pelanggan');
            $nama_bulan = $this->input->post('nama_bulan');
            $tahun = $this->input->post('tahun');
            $data = array(
                'status_bayar' => 'Y',
                'id_cara_bayar' => $this->input->post('id_cara_bayar', TRUE),
                'tgl_bayar' => $this->input->post('tgl_bayar', TRUE),
            );

            $data2 = array(
                'tgl_km' => $this->input->post('tgl_bayar', TRUE),
                'uraian_km' => 'Pembayaran an ' . $nama_pelanggan . ' Bulan ' . $nama_bulan . ' Tahun ' . $tahun,
                'masuk' => $this->input->post('harga_paket', TRUE),
                'keluar' => 0,
                'jenis' => 'Masuk',
                'id_cara_bayar' => $this->input->post('id_cara_bayar', TRUE),
            );

            $this->Tagihan_model->bayar($this->input->post('id_tagihan', TRUE), $data);
            $this->kas_masuk_model->insert($data2);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('tagihan'));
        }
    }
}

/* End of file tagihan.php */
/* Location: ./application/controllers/tagihan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-22 17:57:40 */
/* http://harviacode.com */