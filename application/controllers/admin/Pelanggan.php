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
		$this->load->model('Whatsapp_model');
		$this->load->model('Users_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->uri->segment(3));

		if ($q <> '') {
			$config['base_url'] = base_url() . 'index.php/admin/pelanggan/index?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'index.php/admin/pelanggan/index?q=' . urlencode($q);
		} else {
			$config['base_url'] = base_url() . 'index.php/admin/pelanggan/index/';
			$config['first_url'] = base_url() . 'index.php/admin/pelanggan/index/';
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
		$this->template->load('template', 'admin/pelanggan/pelanggan_list', $data);
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
				'cabang' => $row->nama_cabang,
				'nama_paket' => $row->nama_paket,
			);
			$this->template->load('template', 'admin/pelanggan/pelanggan_read', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('pelanggan'));
		}
	}
	public function rincian($id)
	{
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->uri->segment(3));

		if ($q <> '') {
			$config['base_url'] = base_url() . 'index.php/admin/pelanggan/rincian.html?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'index.php/admin/pelanggan/rincian.html?q=' . urlencode($q);
		} else {
			$config['base_url'] = base_url() . 'index.php/admin/pelanggan/rincian/';
			$config['first_url'] = base_url() . 'index.php/admin/pelanggan/rincian/';
		}

		$config['per_page'] = 30;
		$config['page_query_string'] = FALSE;
		$config['total_rows'] = $this->Pelanggan_model->total_rows($id, $q);
		$riwayat = $this->Pelanggan_model->get_limit_riwayat($id);
		$row = $this->Pelanggan_model->get_by_id_rincian($id);
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);

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
			'cabang' => $row->nama_cabang,
			'nama_paket' => $row->nama_paket,
			'riwayat_data' => $riwayat,
			'q' => $q,
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
		);
		$this->template->load('template', 'admin/pelanggan/pelanggan_rincian', $data);
	}


	public function create()
	{
		$data = array(
			'button' => 'Create',
			'action' => site_url('admin/pelanggan/create_action'),
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
			'id' => set_value('id'),
			'id_user' => set_value('id_user'),
		);
		$data['cabang'] = $this->Cabang_model->tampil_cabang();
		$data['paket'] = $this->Paket_model->tampil_paket();
		$this->template->load('template', 'admin/pelanggan/pelanggan_form', $data);
	}

	public function create_action()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$bisnis = $_SESSION['bisnis'];
			$cabang = $this->input->post('id_cabang', TRUE);
			$paket = $this->input->post('id_paket', TRUE);
			$row = $this->Cabang_model->get_by_id($cabang);
			$row_paket = $this->Paket_model->get_by_id($paket);
			$service = $row_paket->service;
			if ($row) {
				$host = $row->ip_mikrotik;
				$username = $row->user_mikrotik;
				$password = $row->pass_mikrotik;
				
				$API = new Mikweb();				
				// Buat koneksi ke perangkat MikroTik
				if ($API->connect($host, $username, $password)) {

					if($service == 'hostpot') {
						$server =  'all';
						$name =  $this->input->post('username', TRUE);
						$password =  $this->input->post('password', TRUE);
						$profile =  $row_paket->nama_paket;
						$comment =  $this->input->post('nama_pelanggan', TRUE).' - '.$this->input->post('no_wa', TRUE);
						// Kirim permintaan untuk menambahkan pengguna hotspot
						$API->comm("/ip/hotspot/user/add", array(
							"server" => "$server",
							"name" => "$name",
							"password" => "$password",
							"profile" => "$profile",
							"disabled" => "no",
							"comment" => "$comment",
						));
						
						$getuser = $API->comm("/ip/hotspot/user/print", array(
							"?name" => "$name",
						));
						$uid = $getuser[0]['.id'];
						// Tutup koneksi
						$API->disconnect();
					} elseif($service =='ppp') {
						$name =  $this->input->post('username', TRUE);
						$password =  $this->input->post('password', TRUE);
						$profile =  $row_paket->nama_paket;
						$local_address =  $this->input->post('ip', TRUE);
						$remote_address =  $this->input->post('ip', TRUE);
						$comment =  $this->input->post('nama_pelanggan', TRUE).' - '.$this->input->post('no_wa', TRUE);
						// Kirim permintaan untuk menambahkan pengguna hotspot
						$API->comm("/ppp/secret/add", array(
							"name" => "$name",
							"password" => "$password",
							"profile" => "$profile",
							"service" => "pppoe",
							"comment" => "$comment",
							"local-address" => "$local_address",
                            "remote-address" => "$remote_address",
						));
						
						$getuser = $API->comm("/ppp/secret/print", array(
							"?name" => "$name",
						));
						$uid = $getuser[0]['.id'];
						// Tutup koneksi
						$API->disconnect();
					}
				}
			}

			$dataUser = array(
				'username' => $this->input->post('username', TRUE),
				// 'password' => $this->input->post('password',TRUE),
				'password'      => md5($this->input->post('password', true)),
				'nama' => $this->input->post('nama_pelanggan', TRUE),
				'email' => $this->input->post('username', TRUE),
				'alamat' => $this->input->post('alamat', TRUE),
				'kota' => 'Maros',
				'provinsi' => 'Sulsel',
				'telepon' => $this->input->post('no_wa', TRUE),
				'id_level' => 4,
				'id_bisnis' => $bisnis,
				'id_cabang' => $this->input->post('id_cabang', TRUE),
				'is_aktive' => $this->input->post('is_aktive', TRUE),
				'create_date' => date('y-m-d H:i:s')
			);
			$this->Users_model->insert($dataUser);
			$id_user = $this->db->insert_id();

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
				'id_mikrotik_user' => str_replace(
							"*",
							'',
							$uid
				),
				'id_cabang' => $this->input->post('id_cabang', TRUE),
				'id_paket' => $this->input->post('id_paket', TRUE),
				'id_user' => $id_user,
				'id_bisnis' => $bisnis,
				'is_aktive' => $this->input->post('is_aktive', TRUE),
				'create_date' => date('y-m-d H:i:s')
			);
			$this->Pelanggan_model->insert($data);

			$nama_pelanggan = $this->input->post('nama_pelanggan', TRUE);
			$alamat = $this->input->post('alamat', TRUE);
			$no_wa = $this->input->post('no_wa', TRUE);
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			$tgl_mulai = $this->input->post('tgl_mulai', TRUE);
			$id_paket = $this->input->post('id_paket', TRUE);
			$row = $this->Paket_model->get_by_id($id_paket);
			$nama_paket = $row->nama_paket;
			$harga_paket = number_format($row->harga_paket);

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
			$message = 'Selamat Pagi Bapak/Ibu \nIni Adalah WhatsApp notifikasi ABhostpot.\n\nSebelumnya kami ucapkan terima kasih atas kepercayaan yang Anda berikan dengan memilih ABhostpot sebagai Internet Rumah Anda \n\nKami Sampaikan bahwa Akun Internet Aktif sejak ' . $tgl_mulai . '. Informasi Mengenai Pelanggan Sebagai Berikut :\n 1. Nama : ' . $nama_pelanggan . ' \n 2. Alamat : ' . $alamat . ' \n 3. Nomo HP/WA : ' . $no_wa . ' \n 4. Username : ' . $username . ' \n 5. Password : ' . $password . '  \n 6. Jenis Paket : ' . $nama_paket . ' \n 7. Harga Paket : ' . $harga_paket . '\n\n Jika Anda memiliki kendala dan membutuhkan informasi lebih lanjut dalam layanan ABhostpot, dapat menghubungi wa.me/6281355071767 \n Cek Tagihan : https://billingabhostpot.abkreatorpratama.com Dengan Username dan password di atas\n\nhttp://abhostpot.com/login?\n \n*Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas*';
			$data_wa = array(
				'phonenumber' => $hp,
				'message' => $message,
				'url' => whatsapp_url(),
				'link' => "/send-message",
			);
			$this->Whatsapp_model->whatsapp($data_wa);

			$this->session->set_flashdata('message', 'Create Record Success 2');
			redirect(site_url('admin/pelanggan'));
		}
	}

	public function update($id)
	{
		$row = $this->Pelanggan_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('admin/pelanggan/update_action'),
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
				'id_mikrotik_user' => set_value('id', $row->id_mikrotik_user),
				'id_cabang' => set_value('id_cabang', $row->id_cabang),
				'id_paket' => set_value('id_paket', $row->id_paket),
				'id_user' => set_value('id_paket', $row->id_user),
				'is_aktive' => set_value('is_aktive', $row->is_aktive),
			);
			$data['cabang'] = $this->Cabang_model->tampil_cabang();
			$data['paket'] = $this->Paket_model->tampil_paket();
			// $data['data_pelanggan'] = $this->Pelanggan_model->edit_data($id);

			$this->template->load('template', 'admin/pelanggan/pelanggan_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('admin/pelanggan'));
		}
	}

	public function update_action()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id_pelanggan', TRUE));
		} else {

			$id_user = $this->input->post('id_user', TRUE);
			$nama_pelanggan = $this->input->post('nama_pelanggan', TRUE);
			$alamat = $this->input->post('alamat', TRUE);
			$no_wa = $this->input->post('no_wa', TRUE);
			$username = $this->input->post('username', TRUE);
			$password = $this->input->post('password', TRUE);
			$tgl_mulai = $this->input->post('tgl_mulai', TRUE);
			$id_paket = $this->input->post('id_paket', TRUE);
			$is_aktive = $this->input->post('is_aktive', TRUE);
			$row = $this->Paket_model->get_by_id($id_paket);
			if ($id_user == 0) {
				$dataUser = array(
					'username' => $this->input->post('username', TRUE),
					// 'password' => $this->input->post('password',TRUE),
					'password'      => md5($this->input->post('password', true)),
					'nama' => $this->input->post('nama_pelanggan', TRUE),
					'email' => $this->input->post('username', TRUE),
					'alamat' => $this->input->post('alamat', TRUE),
					'kota' => 'Maros',
					'provinsi' => 'Sulsel',
					'telepon' => $this->input->post('no_wa', TRUE),
					'id_level' => 3,
					'is_aktive' => $this->input->post('is_aktive', TRUE),
					'create_date' => date('y-m-d H:i:s')
				);
				$this->Users_model->insert($dataUser);
				$id_user = $this->db->insert_id();
			} else {
				$dataUser = array(
					'username' => $this->input->post('username', TRUE),
					// 'password' => $this->input->post('password',TRUE),
					'password'      => md5($this->input->post('password', true)),
					'nama' => $this->input->post('nama_pelanggan', TRUE),
					'email' => $this->input->post('username', TRUE),
					'alamat' => $this->input->post('alamat', TRUE),
					'kota' => 'Maros',
					'provinsi' => 'Sulsel',
					'telepon' => $this->input->post('no_wa', TRUE),
					'id_level' => '3',
					'is_aktive' => $this->input->post('is_aktive', TRUE),
					'create_date' => date('y-m-d H:i:s')
				);
				$this->Users_model->update($this->input->post('id_user', TRUE), $dataUser);
			}


			$cabang = $this->input->post('id_cabang', TRUE);
			$paket = $this->input->post('id_paket', TRUE);
			$row = $this->Cabang_model->get_by_id($cabang);
			$row_paket = $this->Paket_model->get_by_id($paket);
			$service = $row_paket->service;
			if ($row) {
				$host = $row->ip_mikrotik;
				$username = $row->user_mikrotik;
				$password = $row->pass_mikrotik;
				
				$API = new Mikweb();				
				// Buat koneksi ke perangkat MikroTik
				if ($API->connect($host, $username, $password)) {

					if($service == 'hostpot') {
						$server =  'all';
						$user_id =  '*'.$this->input->post('id_mikrotik_user', TRUE);
						$name =  $this->input->post('username', TRUE);
						$password =  $this->input->post('password', TRUE);
						$profile =  $row_paket->nama_paket;
						$comment =  $this->input->post('nama_pelanggan', TRUE).' - '.$this->input->post('no_wa', TRUE);
						// Kirim permintaan untuk menambahkan pengguna hotspot
						$API->comm("/ip/hotspot/user/set", array(
							".id" => $user_id,
							"server" => "$server",
							"name" => "$name",
							"password" => "$password",
							"profile" => "$profile",
							"disabled" => "no",
							"comment" => "$comment",
						));
						
						$getuser = $API->comm("/ip/hotspot/user/print", array(
							"?name" => "$name",
						));
						$uid = $getuser[0]['.id'];
						// Tutup koneksi
						$API->disconnect();
					} elseif($service =='ppp') {
						$name =  $this->input->post('username', TRUE);
						$password =  $this->input->post('password', TRUE);
						$profile =  $row_paket->nama_paket;
						$local_address =  $this->input->post('ip', TRUE);
						$remote_address =  $this->input->post('ip', TRUE);
						$comment =  $this->input->post('nama_pelanggan', TRUE).' - '.$this->input->post('no_wa', TRUE);
						// Kirim permintaan untuk menambahkan pengguna hotspot
						$API->comm("/ppp/secret/add", array(
							"name" => "$name",
							"password" => "$password",
							"profile" => "$profile",
							"service" => "pppoe",
							"comment" => "$comment",
							"local-address" => "$local_address",
                            "remote-address" => "$remote_address",
						));
						
						$getuser = $API->comm("/ppp/secret/print", array(
							"?name" => "$name",
						));
						$uid = $getuser[0]['.id'];
						// Tutup koneksi
						$API->disconnect();
					}
				}
			}
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
				'id_user' => $id_user,
				'tgl_mulai' => $this->input->post('tgl_mulai', TRUE),
				'is_aktive' => $this->input->post('is_aktive', TRUE),
			);
			$this->Pelanggan_model->update($this->input->post('id_pelanggan', TRUE), $data);

			$nama_paket = $row->nama_paket;
			$sekarang = date('Y-m-d');
			$harga_paket = number_format($row->harga_paket);

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

			if ($is_aktive == 1) {
				$message = 'Selamat Pagi Bapak/Ibu \nIni Adalah WhatsApp notifikasi Update Data ABhostpot.\n\nSebelumnya kami ucapkan terima kasih atas kepercayaan yang Anda berikan dengan telah berlangganan ABhostpot sebagai Internet Rumah Anda \n\nKami Sampaikan bahwa Akun Internet Sudah *AKTIF*  sejak ' . $tgl_mulai . '. Informasi Mengenai Pelanggan Sebagai Berikut :\n 1. Nama : ' . $nama_pelanggan . ' \n 2. Alamat : ' . $alamat . ' \n 3. Nomo HP/WA : ' . $no_wa . ' \n 4. Username : ' . $username . ' \n 5. Password : ' . $password . '  \n 6. Jenis Paket : ' . $nama_paket . ' \n 7. Harga Paket : ' . $harga_paket . '\n\n Jka Anda memiliki kendala dan membutuhkan informasi lebih lanjut dalam layanan ABhostpot, dapat menghubungi wa.me/6281355071767 atau https://billingabhostpot.abkreatorpratama.com\r\nhttp://abhostpot.com/login?\n \n*Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas*';
				$data_wa = array(
					'phonenumber' => $hp,
					'message' => $message,
					'url' => whatsapp_url(),
					'link' => "/send-message",
				);
				$this->Whatsapp_model->whatsapp($data_wa);
			} else {
				$message = 'Selamat Pagi  Bapak/Ibu \nIni Adalah WhatsApp notifikasi Update Data ABhostpot.\n\nSebelumnya kami ucapkan terima kasih atas kepercayaan yang Anda berikan dengan memilih ABhostpot sebagai Internet Rumah Anda \n\nKami Sampaikan bahwa Akun Internet *NONAKTIF* sejak ' . $sekarang . '. \n\n Jka Anda memiliki kendala dan membutuhkan informasi lebih lanjut dalam layanan ABhostpot, dapat menghubungi wa.me/6281355071767\n \n*Informasi dalam pesan ini digenerate dan dikirim otomatis oleh sistem, mohon untuk tidak dibalas*';
				$data_wa = array(
					'phonenumber' => $hp,
					'message' => $message,
					'url' => whatsapp_url(),
					'link' => "/send-message",
				);
				$this->Whatsapp_model->whatsapp($data_wa);
			}

			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('admin/pelanggan'));
		}
	}

	public function delete($id)
	{
		$row = $this->Pelanggan_model->get_by_id($id);
		if ($row) {
			$nama_pelanggan = $row->nama_pelanggan;
			$alamat = $row->alamat;
			$no_wa = $row->no_wa;
			$username = $row->username;
			$password = $row->password;

			$message = 'Informasi Data Pelanggan Delete \n 1. Nama : ' . $nama_pelanggan . ' \n 2. Alamat : ' . $alamat . ' \n 3. Nomo HP/WA : ' . $no_wa . '\n 4. Username : ' . $username . ' \n 5. Password : ' . $password;

			$data_wa = array(
				'phonenumber' => '6281355071767',
				'message' => $message,
				'url' => whatsapp_url(),
				'link' => "/send-message",
			);

			$this->Whatsapp_model->whatsapp($data_wa);
			if ($row->id_user != "") {
				$this->Users_model->delete($row->id_user);
			}
			// $this->Pelanggan_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('admin/pelanggan'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('admin/pelanggan'));
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
		xlsWriteLabel($tablehead, $kolomhead++, "No Hp/WA");
		xlsWriteLabel($tablehead, $kolomhead++, "IP");
		xlsWriteLabel($tablehead, $kolomhead++, "Username");
		xlsWriteLabel($tablehead, $kolomhead++, "Password");
		xlsWriteLabel($tablehead, $kolomhead++, "Nama Wifi");
		xlsWriteLabel($tablehead, $kolomhead++, "Password Wifi");
		xlsWriteLabel($tablehead, $kolomhead++, "Tgl Mulai");
		xlsWriteLabel($tablehead, $kolomhead++, "Cabang");
		xlsWriteLabel($tablehead, $kolomhead++, "Paket");
		xlsWriteLabel($tablehead, $kolomhead++, "is_aktive");

		foreach ($this->Pelanggan_model->get_all() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteLabel($tablebody, $kolombody++, $data->nama_pelanggan);
			xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
			xlsWriteLabel($tablebody, $kolombody++, $data->no_wa);
			xlsWriteLabel($tablebody, $kolombody++, $data->ip);
			xlsWriteLabel($tablebody, $kolombody++, $data->username);
			xlsWriteLabel($tablebody, $kolombody++, $data->password);
			xlsWriteLabel($tablebody, $kolombody++, $data->r_wifi);
			xlsWriteLabel($tablebody, $kolombody++, $data->r_password);
			xlsWriteLabel($tablebody, $kolombody++, $data->tgl_mulai);
			xlsWriteLabel($tablebody, $kolombody++, $data->cabang);
			xlsWriteLabel($tablebody, $kolombody++, $data->nama_paket);
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