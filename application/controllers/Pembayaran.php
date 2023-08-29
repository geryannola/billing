<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        check_not_login();
        $this->load->model('Pembayaran_model');
        $this->load->model('Pelanggan_model');
        $this->load->model('Cabang_model');
        // $this->load->model('Whatsapp_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->uri->segment(3));
        $username = $this->session->userdata('username');

        if ($q <> '') {
            $config['base_url'] = base_url() . '.php/c_url/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'index.php/pembayaran/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'index.php/pembayaran/index/';
            $config['first_url'] = base_url() . 'index.php/pembayaran/index/';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = FALSE;
        $config['total_rows'] = $this->Pembayaran_model->total_rows($q, 'N', $username);
        $pembayaran = $this->Pembayaran_model->get_limit_data($config['per_page'], $start, $q, 'N', $username);
        $total_tagihan = $this->Pembayaran_model->total_tagihan($username);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'pembayaran_data' => $pembayaran,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
            'total_tagihan' => set_value('total_tagihan', $total_tagihan->jml_tagihan),
        );
        $this->template->load('template', 'pembayaran/pembayaran_list', $data);
    }

    public function read($id)
    {
        $row = $this->Pembayaran_model->get_by_id($id);
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
            $this->template->load('template', 'Pembayaran/Pembayaran_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Pembayaran'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('Pembayaran/create_action'),
            'id_Pembayaran' => set_value('id_Pembayaran'),
            'id_pelanggan' => set_value('id_pelanggan'),
            'bulan' => set_value('bulan'),
            'tahun' => set_value('tahun'),
        );
        $data['pelanggan'] = $this->Pelanggan_model->tampil_pelanggan();
        $data['bulan'] = $this->Pembayaran_model->tampil_bulan();
        $data['tahun'] = $this->Pembayaran_model->tampil_tahun();
        $this->template->load('template', 'Pembayaran/Pembayaran_form', $data);
    }

    public function create_action()
    {
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $id_pelanggan = $this->input->post('id_pelanggan');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $diskon = $this->input->post('diskon');
            $sql = $this->db->query("SELECT id_pelanggan FROM Pembayaran where id_pelanggan='$id_pelanggan' AND bulan='$bulan' AND tahun='$tahun'");
            $cek_Pembayaran = $sql->num_rows();

            if ($cek_Pembayaran > 0) {
                $this->session->set_flashdata('message', 'Data ada sudah ada');
                redirect(site_url('Pembayaran'));
            } else {
                $sql = $this->db->query("SELECT id_pelanggan, harga_paket,no_wa, username, nama_pelanggan FROM pelanggan A 
                INNER JOIN paket B ON B.id_paket = A.id_paket 
                where A.id_pelanggan='$id_pelanggan'");
                $data_paket = $sql->row_array();
                $no_wa = $data_paket['no_wa'];
                $bulan = $this->input->post('bulan', TRUE);
                $tahun = $this->input->post('tahun', TRUE);
                $kirim = $this->input->post('kirim', TRUE);
                $keyword = $no_wa . "-" . $bulan . "-" . $tahun;
                if ($kirim == 1) {
                    $harga_paket = number_format($data_paket['harga_paket'] - ($data_paket['harga_paket'] * $diskon / 100));
                    $username = $data_paket['username'];
                    $nama_pelanggan = $data_paket['nama_pelanggan'];
                    //insert db
                    $message = "Yth Pelanggan ABHOSTPOT. \n\nKami Informasikan bahwa Jumlah Pembayaran Internet Anda untuk user $username a.n $nama_pelanggan di Bulan $bulan-$tahun Sebesar $harga_paket*  \n \nBatas Pembayaran Sebelum Tanggal 20 \n\nTempat Pembayaran bisa di Bayarkan Lewat Rasya KIOS (Perum ABC Lr5 A1/96)/\nTranfer Ke Rekening BPD 0102010000148361 an. Syamsul Rijal \n\nInfo mengenai tata cara pembayaran silahkan hubungi Rijal/081355071767,\n\nTerima Kasih telah berlangganan dengan kami. ABhostpot \r\nhttp://abhostpot.com/login?\n \nInformasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas";
                    $data_wa = array(
                        'phonenumber' => $no_wa,
                        'message' => $message,
                        'url' => whatsapp_url(),
                        'link' => "/send-message",
                    );
                    $result = $this->Whatsapp_model->whatsapp($data_wa);
                    $result = json_decode($result, true);
                    if ($result['status'] === true) {
                        $notif = 'Sent';
                    } else {
                        $notif = 'Not Sent';
                    }
                } else {
                    $notif = 'Not Notification';
                }
                $data = array(
                    'id_pelanggan' => $this->input->post('id_pelanggan', TRUE),
                    'bulan' => $this->input->post('bulan', TRUE),
                    'tahun' => $this->input->post('tahun', TRUE),
                    'jml_Pembayaran' => ($data_paket['harga_paket'] - ($data_paket['harga_paket'] * $diskon / 100)),
                    'status_bayar' => 'N',
                    'id_cara_bayar' => 0,
                    'notif_kirim' => $notif,
                    'tgl_bayar' => '0000 - 00 - 00',
                    'keyword' => $keyword,
                    'create_date' => date('y-m-d H:i:s'),
                );

                $this->Pembayaran_model->insert($data);
                $this->session->set_flashdata('message', 'Create Record Success');
                redirect(site_url('Pembayaran'));
            }
        }
    }

    public function create_all()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('Pembayaran/create_action_all'),
            'id_Pembayaran' => set_value('id_Pembayaran'),
            'id_cabang' => set_value('id_cabang'),
            'bulan' => set_value('bulan'),
            'tahun' => set_value('tahun'),
        );
        $data['cabang'] = $this->Cabang_model->tampil_cabang();
        $data['bulan'] = $this->Pembayaran_model->tampil_bulan();
        $data['tahun'] = $this->Pembayaran_model->tampil_tahun();
        $this->template->load('template', 'Pembayaran/Pembayaran_form_all', $data);
    }

    public function create_action_all()
    {
        $id_cabang = $this->input->post('id_cabang');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $kirim = $this->input->post('kirim', TRUE);

        $row = $this->Pelanggan_model->get_all_cabang($id_cabang);

        foreach ($row as $r) {
            $id_pelanggan = $r->id_pelanggan;
            $no_wa = $r->no_wa;
            $username = $r->username;
            $nama_pelanggan = $r->nama_pelanggan;
            $keyword = $no_wa . "-" . $bulan . "-" . $tahun;
            $harga_paket = number_format($r->harga_paket);
            $sql = $this->db->query("SELECT id_pelanggan FROM Pembayaran where id_pelanggan='$id_pelanggan' AND bulan='$bulan' AND tahun='$tahun'");
            $cek_Pembayaran = $sql->num_rows();
            if ($cek_Pembayaran == 0) {
                if ($kirim == 1) {
                    $message = "Yth Pelanggan ABHOSTPOT. \n\nKami Informasikan bahwa Jumlah Pembayaran Internet Anda untuk user $username a.n $nama_pelanggan di Bulan $bulan-$tahun Sebesar $harga_paket*  \n \nBatas Pembayaran Sebelum Tanggal 20 \n\nTempat Pembayaran bisa di Bayarkan Lewat Rasya KIOS (Perum ABC Lr5 A1/96)/\nTranfer Ke Rekening BPD 0102010000148361 an. Syamsul Rijal \n\nInfo mengenai tata cara pembayaran silahkan hubungi Rijal/081355071767,\n\nTerima Kasih telah berlangganan dengan kami. ABhostpot \r\nhttp://abhostpot.com/login?\n \nInformasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas";
                    $data_wa = array(
                        'phonenumber' => $no_wa,
                        'message' => $message,
                        'url' => whatsapp_url(),
                        'link' => "/send-message",
                    );
                    $result = $this->Whatsapp_model->whatsapp($data_wa);
                    $result = json_decode($result, true);
                    if ($result['status'] === true) {
                        $notif = 'Sent';
                    } else {
                        $notif = 'Not Sent';
                    }
                } else {
                    $notif = 'Not Notification';
                }
                $data = array(
                    'id_pelanggan' => $id_pelanggan,
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                    'jml_Pembayaran' => $r->harga_paket,
                    'status_bayar' => 'N',
                    'id_cara_bayar' => 0,
                    'notif_kirim' => $notif,
                    'tgl_bayar' => '0000 - 00 - 00',
                    'keyword' => $keyword,
                    'create_date' => date('y-m-d H:i:s')
                );
                $this->Pembayaran_model->insert($data);
            }
        }
        //insert db
        $this->session->set_flashdata('message', 'Create Record Success');
        redirect(site_url('Pembayaran'));
    }

    public function delete($id)
    {
        $row = $this->Pembayaran_model->get_by_id($id);

        if ($row) {
            $this->Pembayaran_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('Pembayaran'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Pembayaran'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_pelanggan', 'Nama Pelanggan', 'trim|required');
        $this->form_validation->set_rules('bulan', 'Bulan', 'trim|required');
        $this->form_validation->set_rules('tahun', 'Tahun', 'trim|required');
        $this->form_validation->set_rules('diskon', 'Diskon', 'trim|required');

        $this->form_validation->set_rules('id_Pembayaran', 'id_Pembayaran', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function _rules_bayar()
    {
        $this->form_validation->set_rules('id_cara_bayar', 'Cara Bayar', 'trim|required');
        $this->form_validation->set_rules('tgl_bayar', 'Tanggal Bayar', 'trim|required');

        $this->form_validation->set_rules('id_Pembayaran', 'id_Pembayaran', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function bayar($id)
    {
        $row = $this->Pembayaran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Bayar',
                'action' => site_url('Pembayaran/bayar_action'),
                'id_Pembayaran' => set_value('id_Pembayaran', $row->id_Pembayaran),
                'nama_pelanggan' => set_value('nama_pelanggan', $row->nama_pelanggan),
                'no_wa' => set_value('nama_pelanggan', $row->no_wa),
                'harga_paket' => set_value('harga_paket', $row->jml_Pembayaran),
                'bulan' => set_value('bulan', $row->bulan),
                'nama_bulan' => set_value('bulan', $row->nama_bulan),
                'alamat' => set_value('tahun', $row->tahun),
                'tahun' => set_value('tahun', $row->tahun),
                'tgl_bayar' => set_value('tgl_bayar', $row->tgl_bayar),
                'id_cara_bayar' => set_value('id_cara_bayar', $row->id_cara_bayar),
            );
            // $data['cabang'] = $this->Cabang_model->tampil_cabang();
            $data['cara_bayar'] = $this->Pembayaran_model->tampil_bayar();
            $data['data_pelanggan'] = $this->Pembayaran_model->edit_data($id);

            $this->template->load('template', 'Pembayaran/Pembayaran_bayar', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Pembayaran'));
        }
    }
    public function bayar_action()
    {
        $this->_rules_bayar();
        if ($this->form_validation->run() == FALSE) {
            $this->bayar($this->input->post('id_Pembayaran', TRUE));
        } else {
            $nama_pelanggan = $this->input->post('nama_pelanggan');
            $harga_paket = number_format($this->input->post('harga_paket'));
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
            $tgl_bayar = $this->input->post('tgl_bayar', TRUE);
            $no_wa = $this->input->post('no_wa', TRUE);
            $message = "Terima Kasih, Pembayaran internet a/n $nama_pelanggan untuk Bulan $nama_bulan Tahun $tahun, telah kami terima Tanggal $tgl_bayar sejumlah $harga_paket*\n\nTerima Kasih telah berlangganan dengan kami. ABhostpot \r\nhttp://abhostpot.com/login?\n \nInformasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas";
            $data_wa = array(
                'phonenumber' => $no_wa,
                'message' => $message,
                'url' => whatsapp_url(),
                'link' => "/send-message",
            );
            $this->Whatsapp_model->whatsapp($data_wa);
            $this->Pembayaran_model->bayar($this->input->post('id_Pembayaran', TRUE), $data);
            $this->kas_masuk_model->insert($data2);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('Pembayaran'));
        }
    }
    public function notif($id)
    {
        $row = $this->Pembayaran_model->get_by_id($id);

        if ($row) {
            $no_wa = $row->no_wa;
            $nama_pelanggan = $row->nama_pelanggan;
            $harga_paket = number_format($row->jml_Pembayaran);
            $nama_bulan = $row->bulan;
            $tahun = $row->tahun;
            $message = "Yth Pelanggan ABhostpot \n\nPembayaran internet a/n $nama_pelanggan untuk Bulan $nama_bulan Tahun $tahun, mohon di selesaikan sebelum tanggal <h2>20</h2>,  sejumlah $harga_paket*\n\nAbaikan informais ini jika telah melakukan pembayaran\r\nTerima kasih\r\n http://abhostpot.com/login?\n \nInformasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas";

            $data_wa = array(
                'phonenumber' => $no_wa,
                'message' => $message,
                'url' => whatsapp_url(),
                'link' => "/send-message",
            );
            $result = $this->Whatsapp_model->whatsapp($data_wa);
            $result = json_decode($result, true);
            if ($result['status'] === true) {
                $this->session->set_flashdata('message', 'Notifikasi Record Success');
                redirect(site_url('Pembayaran'));
            } else {
                $this->session->set_flashdata('message', 'Notifikasi Record Gagal');
                redirect(site_url('Pembayaran'));
            }
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('Pembayaran'));
        }
    }


    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "Pembayaran.xls";
        $judul = "Pembayaran";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Pelanggann");
        xlsWriteLabel($tablehead, $kolomhead++, "Bulan");
        xlsWriteLabel($tablehead, $kolomhead++, "Tahun");
        xlsWriteLabel($tablehead, $kolomhead++, "Jumlah");
        // xlsWriteLabel($tablehead, $kolomhead++, "Keluar");
        // xlsWriteLabel($tablehead, $kolomhead++, "Jenis");

        foreach ($this->Pembayaran_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->cabang);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_pelanggan);
            xlsWriteNumber($tablebody, $kolombody++, $data->bulan);
            xlsWriteNumber($tablebody, $kolombody++, $data->tahun);
            xlsWriteNumber($tablebody, $kolombody++, $data->jml_Pembayaran);
            // xlsWriteNumber($tablebody, $kolombody++, $data->keluar);
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
        header("Content-Disposition: attachment;Filename=kas_masuk.doc");

        $data = array(
            'kas_data' => $this->Pembayaran_model->get_all(),
            'start' => 0
        );

        $this->load->view('Pembayaran/Pembayaran_doc', $data);
    }
}

/* End of file Pembayaran.php */
/* Location: ./application/controllers/Pembayaran.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-22 17:57:40 */
/* http://harviacode.com */