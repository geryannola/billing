<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class SupportTickets extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		check_not_login();
		$this->load->model('SupportTickets_model');
		$this->load->model('Kas_masuk_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->uri->segment(3));
		$id_username = $_SESSION['id_username'];

		if ($q <> '') {
			$config['base_url'] = base_url() . 'index.php/SupportTickets/index.html?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'index.php/SupportTickets/index.html?q=' . urlencode($q);
		} else {
			$config['base_url'] = base_url() . 'index.php/SupportTickets/index/';
			$config['first_url'] = base_url() . 'index.php/SupportTickets/index/';
		}
// var_dump($_SESSION['id_username']);
		$config['per_page'] = 10;
		$config['page_query_string'] = FALSE;
		$config['total_rows'] = $this->SupportTickets_model->total_rows($q,$id_username);
		$SupportTickets = $this->SupportTickets_model->get_limit_data($config['per_page'], $start, $q,$id_username);
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'SupportTickets_data' => $SupportTickets,
			'q' => $q,
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
		);
		$this->template->load('template', 'pelanggan/supportTickets/supportTickets_list', $data);
	}

	public function read($id)
	{
		$row = $this->SupportTickets_model->get_by_id($id);
		if ($row) {
			$data = array(
				'id_km' => $row->id_km,
				'tgl_km' => $row->tgl_km,
				'uraian_km' => $row->uraian_km,
				'keluar' => $row->keluar,
			);
			$this->template->load('template', 'SupportTickets/SupportTickets_read', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('SupportTickets'));
		}
	}

	public function create()
	{
		$data = array(
			'button' => 'Create',
			'action' => site_url('pelanggan/supportTickets/create_action'),
			'id_support_tickets' => set_value('id_support_tickets'),
			'jenis_ticket' => set_value('jenis_ticket'),
			'judul_ticket' => set_value('judul_ticket'),
			'pesan_ticket' => set_value('pesan_ticket'),
			'foto_ticket' => set_value('foto_ticket'),
			'is_aktive' => set_value('is_aktive'),
			'create_date' => set_value('create_date'),
			'Attachments' => set_value('Attachments'),
			'create_user' => $_SESSION['id_username']
		);
		$data['m_jenis_ticket'] = $this->SupportTickets_model->tampil_jenisTicket();
		$this->template->load('template', 'pelanggan/SupportTickets/SupportTickets_form', $data);
	}

	public function create_action()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$attachments = $this->input->post('attachments', TRUE);
			if ($attachments != "") {
				$ekstensi_diperbolehkan    = array('png', 'jpg', 'jpeg', 'pdf');
				$nama = $_FILES['attachments']['name'];
				$x = explode('.', $nama);
				$ekstensi = strtolower(end($x));
				$ukuran    = $_FILES['attachments']['size'];
				$file_tmp = $_FILES['attachments']['tmp_name'];
				$date = date('y-m-d H:i:s');
				$datenow = strtotime($date);
				$image = $nira . '.' . $datenow . '.' . $ekstensi;
				// $id_iuran = $this->uuid->v4();
				// $id_iuran = preg_replace("/[-]/", "", $id_iuran);

				$data = array(
					'jenis_ticket' => $this->input->post('jenis_ticket', TRUE),
					'judul_ticket' => $this->input->post('judul_ticket', TRUE),
					'pesan_ticket' => $this->input->post('pesan_ticket', TRUE),
					'foto_ticket' => $this->input->post('foto_ticket', TRUE),
					'create_user' => $this->input->post('create_user', TRUE),
					'is_aktive' => 1,
					'create_date' => date('y-m-d H:i:s')
				);
				if (in_array($ekstensi, $ekstensi_diperbolehkan) == true) {
					if ($ukuran < 1044070) {
						$query =   $this->Iuran_model->insert($data);
						// move_uploaded_file($file_tmp, '/var/www/html/login/assets/images/buktibayar/' . $image);
						move_uploaded_file($file_tmp, 'assets/images/iuran/' . $image);

						// WhatsAPP 
						// WA Pengurus
						$pengurus_data = $this->Pengurus_model->get_by_organisasi($id_organisasi);
						$messagePengurus = 'Halo Admin, Selamat Pagi Bapak/Ibu \nAda Penambahan Iuran at ' . $nira;
						foreach ($pengurus_data as $pengurus) {
							$hp = no_wa($pengurus->telepon);
							$wa_pengurus = array(
								'phonenumber' => $hp,
								'message' => $messagePengurus,
								'url' => whatsapp_url(),
								'link' => "/send-message",
							);
							$this->Whatsapp_model->whatsapp($wa_pengurus);
						}

						if ($query == true) {
							$this->session->set_flashdata('message', 'Create Record Success');
							redirect(site_url('iuran'));
						} else {
							$this->session->set_flashdata('message', 'GAGAL MENGUPLOAD GAMBAR');
							redirect(site_url('iuran'));
						}
					} else {
						$this->session->set_flashdata('message', 'UKURAN FILE TERLALU BESAR');
						redirect(site_url('iuran'));
					}
				} else {
					$this->session->set_flashdata('message', 'EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN');
					redirect(site_url('iuran'));
				}


				$this->SupportTickets_model->insert($data);
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('pelanggan/SupportTickets'));
			} else {
			}
		}
	}

	public function update($id)
	{
		$row = $this->SupportTickets_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('SupportTickets/update_action'),
				'id_km' => set_value('id_km', $row->id_km),
				'tgl_km' => set_value('tgl_km', $row->tgl_km),
				'uraian_km' => set_value('uraian_km', $row->uraian_km),
				'keluar' => set_value('keluar', $row->keluar),
				'id_cara_bayar' => set_value('id_cara_bayar', $row->id_cara_bayar),
			);
			$data['cara_bayar'] = $this->Kas_masuk_model->tampil_bayar();
			$this->template->load('template', 'pelanggan/SupportTickets/SupportTickets_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('pelanggan/SupportTickets'));
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
				'id_cara_bayar' => $this->input->post('id_cara_bayar', TRUE),
			);

			$this->SupportTickets_model->update($this->input->post('id_km', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('pelanggan/SupportTickets'));
		}
	}

	public function delete($id)
	{
		$row = $this->SupportTickets_model->get_by_id($id);

		if ($row) {
			$this->SupportTickets_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('pelanggan/SupportTickets'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('pelanggan/SupportTickets'));
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('jenis_ticket', 'Jenis Ticket', 'trim|required');
		$this->form_validation->set_rules('judul_ticket', 'Judul Ticket', 'trim|required');
		$this->form_validation->set_rules('pesan_ticket', 'Pesan Ticket', 'trim|required');

		$this->form_validation->set_rules('id_support_tickets', 'id_support_tickets', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	public function excel()
	{
		$this->load->helper('exportexcel');
		$namaFile = "SupportTickets.xls";
		$judul = "SupportTickets";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Keluar");
		xlsWriteLabel($tablehead, $kolomhead++, "Cara Bayar");

		foreach ($this->SupportTickets_model->get_all() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteLabel($tablebody, $kolombody++, $data->tgl_km);
			xlsWriteLabel($tablebody, $kolombody++, $data->uraian_km);
			xlsWriteNumber($tablebody, $kolombody++, $data->keluar);
			xlsWriteLabel($tablebody, $kolombody++, $data->cara_bayar);

			$tablebody++;
			$nourut++;
		}

		xlsEOF();
		exit();
	}

	public function word()
	{
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment;Filename=SupportTickets.doc");

		$data = array(
			'SupportTickets_data' => $this->SupportTickets_model->get_all(),
			'start' => 0
		);

		$this->load->view('SupportTickets/SupportTickets_doc', $data);
	}
}

/* End of file SupportTickets.php */
/* Location: ./application/controllers/SupportTickets.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-22 18:09:46 */
/* http://harviacode.com */
