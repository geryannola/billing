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
		$this->load->model('Cabang_model');
		$this->load->model('Whatsapp_model');
		$this->load->model('Xendit_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->uri->segment(3));

		if ($q <> '') {
			$config['base_url'] = base_url() . 'index.php/tagihan/index?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'index.php/tagihan/index?q=' . urlencode($q);
		} else {
			$config['base_url'] = base_url() . 'index.php/tagihan/index/';
			$config['first_url'] = base_url() . 'index.php/tagihan/index/';
		}

		$config['per_page'] = 10;
		$config['page_query_string'] = FALSE;
		$config['total_rows'] = $this->Tagihan_model->total_rows($q, 'N');
		$tagihan = $this->Tagihan_model->get_limit_data($config['per_page'], $start, $q, 'N');
		$total_tagihan = $this->Tagihan_model->total_tagihan();
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'tagihan_data' => $tagihan,
			'q' => $q,
			'pagination' => $this->pagination->create_links(),
			'

            ' => $config['total_rows'],
			'start' => $start,
			'total_tagihan' => set_value('total_tagihan', $total_tagihan->jml_tagihan),
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
		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$id_pelanggan = $this->input->post('id_pelanggan');
			$bulan = $this->input->post('bulan');
			$tahun = $this->input->post('tahun');
			$diskon = $this->input->post('diskon');
			$base_url = base_url();
			$sql = $this->db->query("SELECT id_pelanggan FROM tagihan where id_pelanggan='$id_pelanggan' AND bulan='$bulan' AND tahun='$tahun'");
			$cek_tagihan = $sql->num_rows();

			if ($cek_tagihan > 0) {
				$this->session->set_flashdata('message', 'Data ada sudah ada');
				redirect(site_url('tagihan'));
			} else {
				$sql = $this->db->query("SELECT id_pelanggan, harga_paket,no_wa, username, nama_pelanggan FROM pelanggan A 
                INNER JOIN paket B ON B.id_paket = A.id_paket 
                where A.id_pelanggan='$id_pelanggan'");
				$data_paket = $sql->row_array();
				$no_wa = $data_paket['no_wa'];

				if (!preg_match("/[^+0-9]/", trim($no_wa))) {
					// cek apakah no hp karakter ke 1 dan 2 adalah angka 62
					if (substr(trim($no_wa), 0, 2) == "62") {
						$hp    = trim($no_wa);
					}
					// cek apakah no hp karakter ke 1 adalah angka 0
					else if (substr(trim($no_wa), 0, 1) == "0") {
						$hp    = "62" . substr(trim($no_wa), 1);
					}
				}

				$bulan = $this->input->post('bulan', TRUE);
				$tahun = $this->input->post('tahun', TRUE);
				$kirim = $this->input->post('kirim', TRUE);
				$keyword = $no_wa . "-" . $bulan . "-" . $tahun;
				if ($kirim == 1) {

					$harga_paket = number_format($data_paket['harga_paket'] - ($data_paket['harga_paket'] * $diskon / 100));
					$username = $data_paket['username'];
					$nama_pelanggan = $data_paket['nama_pelanggan'];
					$date_future = new DateTime('now', new DateTimeZone('UTC'));
					$date_future->add(new DateInterval('P1Y'));
        			$formatted_future = $date_future->format('Y-m-d\TH:i:s.u\Z');
				    $data_xendit = array(
						'url' => 'https://api.xendit.co',
						'link' => "/qr_codes",
						'timestamp' => time(),
						'reference_id' => 'order-id-'. time(),
						'expires_at' => $formatted_future,
					);
					// $result = $this->Xendit_model->CreateQRCode($data_xendit);
					$result = $this->Xendit_model->CreateInvoice();
					$result = json_decode($result, true);
					$id = $result['id'];
					$reference_id = $result['reference_id'];
					// $result = $this->Xendit_model->CreateQRCode($data_xendit);
					var_dump($result);
					die();
					
					$message = 'Yth Pelanggan ABHOSTPOT \n\nKami Informasikan bahwa Jumlah Tagihan Internet Anda untuk: \nuser ' . $username . ' an ' . $nama_pelanggan . '\nBulan = ' . $bulan . ' Tahun = ' . $tahun . ' \nSebesar ' . $harga_paket . '  \n \nBatas Pembayaran Sebelum *Tanggal 20* \n\nTempat Pembayaran bisa di Bayarkan Lewat Rasya KIOS (Perum ABC Lr5 A1/96)\nPembayaran melalui QRIS = ' . $base_url . 'qr?kode='.$id.'\nTranfer Ke Rekening BPD 0102010000148361 an Syamsul Rijal \n\nInfo mengenai tata cara pembayaran silahkan hubungi \nwa.me/6281355071767\nCek Tagihan = ' . $base_url . ' \nTerima Kasih telah berlangganan dengan kami ABhostpot \n\n\n*Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem mohon untuk tidak dibalas*';
					$data_wa = array(
						'phonenumber' => $hp,
						'message' => $message,
						'url' => whatsapp_url(),
						'link' => "/send-message",
					);
					$result = $this->Whatsapp_model->whatsapp($data_wa);
					$result = json_decode($result, true);
					// var_dump($message);
					// die();

					if ($result['success'] === true) {
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
					'jml_tagihan' => ($data_paket['harga_paket'] - ($data_paket['harga_paket'] * $diskon / 100)),
					'status_bayar' => 'N',
					'id_cara_bayar' => 0,
					'notif_kirim' => $notif,
					'tgl_bayar' => '0000 - 00 - 00',
					'keyword' => $keyword,
					'qr_xendit' => $id,
					'reference_id' => $reference_id,
					'create_date' => date('y-m-d H:i:s'),
				);

				$this->Tagihan_model->insert($data);
				$this->session->set_flashdata('message', 'Create Record Success');
				redirect(site_url('tagihan'));
			}
		}
	}

	public function create_all()
	{
		$data = array(
			'button' => 'Create',
			'action' => site_url('tagihan/create_action_all'),
			'id_tagihan' => set_value('id_tagihan'),
			'id_cabang' => set_value('id_cabang'),
			'bulan' => set_value('bulan'),
			'tahun' => set_value('tahun'),
		);
		$data['cabang'] = $this->Cabang_model->tampil_cabang();
		$data['bulan'] = $this->Tagihan_model->tampil_bulan();
		$data['tahun'] = $this->Tagihan_model->tampil_tahun();
		$this->template->load('template', 'tagihan/tagihan_form_all', $data);
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

			if (!preg_match("/[^+0-9]/", trim($no_wa))) {
				// cek apakah no hp karakter ke 1 dan 2 adalah angka 62
				if (substr(trim($no_wa), 0, 2) == "62") {
					$hp    = trim($no_wa);
				}
				// cek apakah no hp karakter ke 1 adalah angka 0
				else if (substr(trim($no_wa), 0, 1) == "0") {
					$hp    = "62" . substr(trim($no_wa), 1);
				}
			}


			$sql = $this->db->query("SELECT id_pelanggan FROM tagihan where id_pelanggan='$id_pelanggan' AND bulan='$bulan' AND tahun='$tahun'");
			$cek_tagihan = $sql->num_rows();
			if ($cek_tagihan == 0) {
				if ($kirim == 1) {
					$message = 'Yth Pelanggan ABHOSTPOT \n\nKami Informasikan bahwa Jumlah Tagihan Internet Anda untuk: \nuser ' . $username . ' an ' . $nama_pelanggan . '\nBulan ' . $bulan . ' - ' . $tahun . ' \nSebesar ' . $harga_paket . '  \n \nBatas Pembayaran Sebelum Tanggal 20 \n\nTempat Pembayaran bisa di Bayarkan Lewat Rasya KIOS (Perum ABC Lr5 A1/96)/\nTranfer Ke Rekening BPD 0102010000148361 an Syamsul Rijal \n\nInfo mengenai tata cara pembayaran silahkan hubungi \nwa.me/6281355071767\n\nTerima Kasih telah berlangganan dengan kami ABhostpot \nhttps://billingabhostpot.abkreatorpratama.com/\n\n*Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem mohon untuk tidak dibalas*';
					$data_wa = array(
						'phonenumber' => $hp,
						'message' => $message,
						'url' => whatsapp_url(),
						'link' => "/send-message",
					);
					$result = $this->Whatsapp_model->whatsapp($data_wa);
					$result = json_decode($result, true);
					if ($result['success'] === true) {
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
					'jml_tagihan' => $r->harga_paket,
					'status_bayar' => 'N',
					'id_cara_bayar' => 0,
					'notif_kirim' => $notif,
					'tgl_bayar' => '0000 - 00 - 00',
					'keyword' => $keyword,
					'create_date' => date('y-m-d H:i:s')
				);
				$this->Tagihan_model->insert($data);
			}
		}
		//insert db
		$this->session->set_flashdata('message', 'Create Record Success');
		redirect(site_url('tagihan'));
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
		$this->form_validation->set_rules('diskon', 'Diskon', 'trim|required');

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
				'no_wa' => set_value('nama_pelanggan', $row->no_wa),
				'harga_paket' => set_value('harga_paket', $row->jml_tagihan),
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
			$kirim = $this->input->post('kirim');
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
			if ($kirim == 1) {
				$tgl_bayar = $this->input->post('tgl_bayar', TRUE);
				$no_wa = $this->input->post('no_wa', TRUE);
				if (!preg_match("/[^+0-9]/", trim($no_wa))) {
					// cek apakah no hp karakter ke 1 dan 2 adalah angka 62
					if (substr(trim($no_wa), 0, 2) == "62") {
						$hp    = trim($no_wa);
					}
					// cek apakah no hp karakter ke 1 adalah angka 0
					else if (substr(trim($no_wa), 0, 1) == "0") {
						$hp    = "62" . substr(trim($no_wa), 1);
					}
				}

				$message = 'Terima Kasih, Pembayaran internet a/n ' . $nama_pelanggan . ' untuk Bulan ' . $nama_bulan . ' Tahun ' . $tahun . ', telah kami terima Tanggal ' . $tgl_bayar . ' sejumlah ' . $harga_paket . '\n\nTerima Kasih telah berlangganan dengan kami. ABhostpot \r\nhttp://abhostpot.com/login?\n \n Cek Pembayaran = https://billingabhostpot.abkreatorpratama.com \n\n*Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas*';
				$data_wa = array(
					'phonenumber' => $hp,
					'message' => $message,
					'url' => whatsapp_url(),
					'link' => "/send-message",
				);
				$this->Whatsapp_model->whatsapp($data_wa);
			}
			$this->Tagihan_model->bayar($this->input->post('id_tagihan', TRUE), $data);
			$this->kas_masuk_model->insert($data2);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('tagihan'));
		}
	}
	public function notif($id)
	{
		$row = $this->Tagihan_model->get_by_id($id);

		if ($row) {
			$no_wa = $row->no_wa;
			if (!preg_match("/[^+0-9]/", trim($no_wa))) {
				// cek apakah no hp karakter ke 1 dan 2 adalah angka 62
				if (substr(trim($no_wa), 0, 2) == "62") {
					$hp    = trim($no_wa);
				}
				// cek apakah no hp karakter ke 1 adalah angka 0
				else if (substr(trim($no_wa), 0, 1) == "0") {
					$hp    = "62" . substr(trim($no_wa), 1);
				}
			}
			$nama_pelanggan = $row->nama_pelanggan;
			$harga_paket = number_format($row->jml_tagihan);
			$nama_bulan = $row->nama_bulan;
			$tahun = $row->tahun;
// 			$message = 'السَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ

// Maha suci Allah yang telah menjadikan segala sesuatu lebih indah dan sempurna.

// Tanpa mengurangi rasa hormat, perkenankan kami mengundang Bapak/Ibu/Saudara/i, teman sekaligus sahabat, untuk menghadiri acara pernikahan kami :

// Liza & Wawan

// Berikut link untuk info lengkap dari acara kami untuk mengantarkan Bapak/Ibu, teman, serta sahabat ketujuan :
// https://jadinikah.org/khalizawawan/?to=' . $nama . '

// Merupakan suatu kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan untuk hadir dan memberikan doa restu.

// Mohon maaf perihal undangan hanya di bagikan melalui  pesan ini.

// وَالسَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ

// Kami yang berbahagia
// Liza & Wawan';
			$message = 'Yth Pelanggan ABhostpot \n\nPembayaran internet a/n ' . $nama_pelanggan . ' untuk :\nBulan = ' . $nama_bulan . ' \nTahun = ' . $tahun . '\nJumlah = ' . $harga_paket . '\nMohon di selesaikan sebelum tanggal *20*, \n\n*Abaikan informasi ini jika telah melakukan pembayaran\r\nCek Pembayaran melalui = \n https://billingabhostpot.abkreatorpratama.com/ \n\nTerima kasih\r\n http://abhostpot.com/login?\n \n*Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas*';

			$data_wa = array(
				'phonenumber' => $hp,
				'message' => $message,
				'url' => whatsapp_url(),
				'link' => "/send-message",
			);
			$result = $this->Whatsapp_model->whatsapp($data_wa);
			$result = json_decode($result, true);
			if ($result['status'] === true) {
				$this->session->set_flashdata('message', 'Notifikasi Record Success');
				redirect(site_url('tagihan'));
			} else {
				$this->session->set_flashdata('message', 'Notifikasi Record Gagal');
				redirect(site_url('tagihan'));
			}
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('tagihan'));
		}
	}

	public function notif_all()
	{

		$row = $this->Tagihan_model->get_by_notif();

		foreach ($row as $r) {
			// var_dump($r);
			// die();
			$no_wa = $r->no_wa;
			if (!preg_match("/[^+0-9]/", trim($no_wa))) {
				// cek apakah no hp karakter ke 1 dan 2 adalah angka 62
				if (substr(trim($no_wa), 0, 2) == "62") {
					$hp    = trim($no_wa);
				}
				// cek apakah no hp karakter ke 1 adalah angka 0
				else if (substr(trim($no_wa), 0, 1) == "0") {
					$hp    = "62" . substr(trim($no_wa), 1);
				}
			}
			$nama_pelanggan = $r->nama_pelanggan;
			$harga_paket = number_format($r->jml_tagihan);
			$nama_bulan = $r->nama_bulan;
			$tahun = $r->tahun;
			$message = 'Yth Pelanggan ABhostpot \n\nPembayaran internet a/n ' . $nama_pelanggan . ' untuk :\nBulan = ' . $nama_bulan . ' \nTahun = ' . $tahun . '\nJumlah = ' . $harga_paket . '\nMohon di selesaikan sebelum tanggal *20*, \n\n*Abaikan informasi ini jika telah melakukan pembayaran\r\nCek Pembayaran melalui = \n https://billingabhostpot.abkreatorpratama.com/ \n\nTerima kasih\r\n http://abhostpot.com/login?\n \n*Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas*';

			$data_wa = array(
				'phonenumber' => $hp,
				'message' => $message,
				'url' => whatsapp_url(),
				'link' => "/send-message",
			);
			$result = $this->Whatsapp_model->whatsapp($data_wa);
			$result = json_decode($result, true);
		}

		$this->session->set_flashdata('message', 'Notifikasi Record Success');
		redirect(site_url('tagihan'));
	}


	public function excel()
	{
		$this->load->helper('exportexcel');
		$namaFile = "tagihan.xls";
		$judul = "tagihan";
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

		foreach ($this->Tagihan_model->get_all() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteLabel($tablebody, $kolombody++, $data->cabang);
			xlsWriteLabel($tablebody, $kolombody++, $data->nama_pelanggan);
			xlsWriteNumber($tablebody, $kolombody++, $data->bulan);
			xlsWriteNumber($tablebody, $kolombody++, $data->tahun);
			xlsWriteNumber($tablebody, $kolombody++, $data->jml_tagihan);
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
			'kas_data' => $this->Tagihan_model->get_all(),
			'start' => 0
		);

		$this->load->view('tagihan/tagihan_doc', $data);
	}
}

/* End of file tagihan.php */
/* Location: ./application/controllers/tagihan.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-22 17:57:40 */
/* http://harviacode.com */