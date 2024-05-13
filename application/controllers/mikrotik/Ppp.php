<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ppp extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		check_not_login();
		check_admin();

		$this->load->model('Ppp_model');
		$this->load->model('PppProfile_model');
		$this->load->model('Mikrotik_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->uri->segment(3));

		if ($q <> '') {
			$config['base_url'] = base_url() . 'index.php/mikrotik/Ppp/index.html?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'index.php/mikrotik/Ppp/index.html?q=' . urlencode($q);
		} else {
			$config['base_url'] = base_url() . 'index.php/mikrotik/Ppp/index/';
			$config['first_url'] = base_url() . 'index.php/mikrotik/Ppp/index/';
		}

		$config['per_page'] = 100;
		$config['page_query_string'] = FALSE;
		$config['total_rows'] = $this->Ppp_model->total_rows($q);
		$Ppp = $this->Ppp_model->get_limit_data($config['per_page'], $start, $q);
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'ppp_data' => $Ppp,
			'q' => $q,
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
		);
		$this->template->load('template', 'Ppp/Ppp_list', $data);
	}

	// public function read($id)
	// {
	// 	$row = $this->Ppp_model->get_by_id($id);
	// 	if ($row) {
	// 		$Ppp = $row->id_Ppp;
	// 		$host = $row->ip_mikrotik;
	// 		$username = $row->user_mikrotik;
	// 		$password = $row->pass_mikrotik;

	// 		$API = new Mikweb();
	// 		if ($API->connect(
	// 			$host,
	// 			$username,
	// 			$password
	// 		)) {
	// 			// // $API->write('/interface/print');
	// 			// $API->write('/ppp/secret/print');
	// 			// $interface = $API->read();
	// 			// $result = json_encode($interface);
	// 			// echo $result;
	// 			// die();
	// 			// Ppp
	// 			$API->write('/ip/hotspot/user/print');
	// 			$users = $API->read();
	// 			foreach ($users as $user) {
	// 				$id_ppp = $user[".id"];
	// 				if (isset($user['default'])) {
	// 					// Lakukan sesuatu dengan nilai $array['default']
	// 					$default = $user["default"];
	// 				} else {
	// 					// Handle kasus ketika indeks 'default' tidak terdefinisi
	// 					$default = '-';
	// 				}
	// 				if (isset($user['comment'])) {
	// 					// Lakukan sesuatu dengan nilai $array['default']
	// 					$comment = $user["comment"];
	// 				} else {
	// 					// Handle kasus ketika indeks 'default' tidak terdefinisi
	// 					$comment = '-';
	// 				}
	// 				if ($this->Ppp_model->check($id_ppp, $id) == 0) {
	// 					$data_ppp = array(
	// 						'id' => $user[".id"],
	// 						'name' => $user["name"],
	// 						'uptime' => $user["uptime"],
	// 						'bytes-in' => $user["bytes-in"],
	// 						'bytes-out' => $user["bytes-out"],
	// 						'packets-in' => $user["packets-in"],
	// 						'packets-out' => $user["packets-out"],
	// 						'default' => $default,
	// 						'dynamic' => $user["dynamic"],
	// 						'disabled' => $user["disabled"],
	// 						'comment' => $comment,
	// 						'id_Ppp' => $Ppp,
	// 						'is_aktive' => 1,
	// 						'create_date' => date('y-m-d H:i:s')
	// 					);
	// 					$this->Ppp_model->insert($data_ppp);
	// 				} else {
	// 					$data_ppp = array(
	// 						'id' => $user[".id"],
	// 						'name' => $user["name"],
	// 						'uptime' => $user["uptime"],
	// 						'bytes-in' => $user["bytes-in"],
	// 						'bytes-out' => $user["bytes-out"],
	// 						'packets-in' => $user["packets-in"],
	// 						'packets-out' => $user["packets-out"],
	// 						'default' => $default,
	// 						'dynamic' => $user["dynamic"],
	// 						'disabled' => $user["disabled"],
	// 						'comment' => $comment,
	// 						'id_Ppp' => $Ppp,
	// 						'is_aktive' => 1,
	// 						'create_date' => date('y-m-d H:i:s')
	// 					);
	// 					$this->Ppp_model->update($id_ppp, $Ppp, $data_ppp);
	// 				}
	// 			}
	// 			// PPP
	// 			$API->write('/ppp/secret/print');
	// 			$ppp = $API->read();
	// 			foreach ($ppp as $p) {
	// 				$id_ppp = $p[".id"];
	// 				if (isset($user['caller-id'])) {
	// 					// Lakukan sesuatu dengan nilai $array['default']
	// 					$caller_id = $user["caller-id"];
	// 				} else {
	// 					// Handle kasus ketika indeks 'default' tidak terdefinisi
	// 					$caller_id = '-';
	// 				}
	// 				if (isset($user['last-logged-out'])) {
	// 					// Lakukan sesuatu dengan nilai $array['default']
	// 					$last_logged_out = $user["last-logged-out"];
	// 				} else {
	// 					// Handle kasus ketika indeks 'default' tidak terdefinisi
	// 					$last_logged_out = '-';
	// 				}
	// 				if (isset($user['last-caller-id'])) {
	// 					// Lakukan sesuatu dengan nilai $array['default']
	// 					$last_caller_id = $user["last-caller-id"];
	// 				} else {
	// 					// Handle kasus ketika indeks 'default' tidak terdefinisi
	// 					$last_caller_id = '-';
	// 				}
	// 				if ($this->Ppp_model->check($id_ppp, $id) == 0) {
	// 					$data_ppp = array(
	// 						'id' => $p[".id"],
	// 						'name' => $p["name"],
	// 						'service' => $p["service"],
	// 						'caller-id' => $caller_id,
	// 						'password' => $p["password"],
	// 						'profile' => $p["profile"],
	// 						'local-address' => $p["local-address"],
	// 						'remote-address' => $p["remote-address"],
	// 						'Ppps' => $p["Ppps"],
	// 						'limit-bytes-in' => $p["limit-bytes-in"],
	// 						'limit-bytes-out' => $p["limit-bytes-out"],
	// 						'last-logged-out' => $last_logged_out,
	// 						'last-caller-id' => $last_caller_id,
	// 						'last-disconnect-reason' => $p["last-disconnect-reason"],
	// 						'disabled' => $p["disabled"],
	// 						'id_Ppp' => $Ppp,
	// 						'is_aktive' => 1,
	// 						'create_date' => date('y-m-d H:i:s')
	// 					);
	// 					$this->Ppp_model->insert($data_ppp);
	// 				} else {
	// 					$data_ppp = array(
	// 						'id' => $p[".id"],
	// 						'name' => $p["name"],
	// 						'service' => $p["service"],
	// 						'caller-id' => $caller_id,
	// 						'password' => $p["password"],
	// 						'profile' => $p["profile"],
	// 						'local-address' => $p["local-address"],
	// 						'remote-address' => $p["remote-address"],
	// 						'Ppps' => $p["Ppps"],
	// 						'limit-bytes-in' => $p["limit-bytes-in"],
	// 						'limit-bytes-out' => $p["limit-bytes-out"],
	// 						'last_logged_out' => $last_logged_out,
	// 						'last-caller-id' => $last_caller_id,
	// 						'last-disconnect-reason' => $p["last-disconnect-reason"],
	// 						'disabled' => $p["disabled"],
	// 						'id_Ppp' => $Ppp,
	// 						'is_aktive' => 1,
	// 						'create_date' => date('y-m-d H:i:s')
	// 					);
	// 					$this->Ppp_model->update($id_ppp, $Ppp, $data_ppp);
	// 				}
	// 			}
	// 			$API->disconnect();
	// 			redirect(site_url('mikrotik/Ppp'));
	// 		} else {
	// 			redirect(site_url('mikrotik/Ppp'));
	// 		}
	// 	} else {
	// 		$this->session->set_flashdata('message', 'Record Not Found');
	// 		redirect(site_url('mikrotik/Ppp'));
	// 	}
	// }

	public function create()
	{
		$row = $this->Mikrotik_model->get_by_aktive();
		if ($row) {
			$data = array(
				'button' => 'Create',
				'action' => site_url('mikrotik/ppp/create_action'),
				'id' => set_value('id'),
				'id_ppp' => set_value('id_ppp'),
				'id_mikrotik' => $row->id_mikrotik,
				'name' => set_value('name'),
				'password' => set_value('password'),
				'profile' => set_value('profile'),
				'disabled' => set_value('disabled'),
				'comment' => set_value('comment'),
				'is_aktive' => set_value('is_aktive'),
				'create_date' => set_value('create_date')
			);
			$data['profile_data'] = $this->PppProfile_model->tampil_profilePpp();
			$this->template->load('template', 'ppp/ppp_form', $data);
		}
	}

	public function create_action()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$row = $this->Mikrotik_model->get_by_aktive();
			if ($row) {
				$host = $row->ip_mikrotik;
				$username = $row->user_mikrotik;
				$password = $row->pass_mikrotik;

				$API = new Mikweb();

				// Buat koneksi ke perangkat MikroTik
				if ($API->connect($host, $username, $password)) {
					$server =  'all';
					$name =  $this->input->post('name', TRUE);
					$password =  $this->input->post('password', TRUE);
					$profile =  $this->input->post('profile', TRUE);
					$comment =  $this->input->post('comment', TRUE);
					// Kirim permintaan untuk menambahkan pengguna hotspot
					$API->comm("/ppp/secret/add", array(
						"service" => "any",
						"name" => "$name",
						"password" => "$password",
						"profile" => "$profile",
					));
					$getuser = $API->comm("/ppp/secret/print", array(
						"?name" => "$name",
					));
					$uid = $getuser[0]['.id'];
					// Tutup koneksi
					$API->disconnect();

					$data = array(
						'id_mikrotik' => $this->input->post('id_mikrotik', TRUE),
						'id' => str_replace(
							"*",
							'',
							$uid
						),
						'name' => $this->input->post('name', TRUE),
						'password' => $this->input->post('password', TRUE),
						'service' => "any",
						'profile' => $this->input->post('profile', TRUE),
						'is_aktive' => $this->input->post('is_aktive', TRUE),
						'create_date' => date('y-m-d H:i:s')
					);

					$this->Ppp_model->insert($data);
					$this->session->set_flashdata('message', 'Create Record Success');
					redirect(site_url('mikrotik/ppp'));
				} else {
					redirect(site_url('mikrotik/ppp'));
				}
			} else {
				redirect(site_url('mikrotik/ppp'));
			}
		}
	}

	public function update($id)
	{
		$row = $this->Ppp_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('mikrotik/ppp/update_action'),
				'id' => set_value('id', $row->id),
				'id_ppp' => set_value('id_ppp', $row->id_ppp),
				'name' => set_value('name', $row->name),
				'password' => set_value('password', $row->password),
				'profile' => set_value('profile', $row->profile),
				'id_mikrotik' => set_value('id_mikrotik', $row->id_mikrotik),
				'is_aktive' => set_value('is_aktive', $row->is_aktive),
				'create_date' => set_value('create_date', $row->create_date),
			);
			$data['profile_data'] = $this->PppProfile_model->tampil_profilePpp();
			$data['data_ppp'] = $this->Ppp_model->edit_data($id);
			$this->template->load('template', 'ppp/ppp_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('mikrotik/ppp'));
		}
	}

	public function update_action()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id_ppp', TRUE));
		} else {
			$rowMikrotik = $this->Mikrotik_model->get_by_aktive();
			if ($rowMikrotik) {
				$host = $rowMikrotik->ip_mikrotik;
				$username = $rowMikrotik->user_mikrotik;
				$password = $rowMikrotik->pass_mikrotik;
				$id = $this->input->post('id', TRUE);
				// Buat objek RouterosAPI
				$API = new Mikweb();

				// Buat koneksi ke perangkat MikroTik
				if ($API->connect($host, $username, $password)) {
					// Kirim permintaan untuk menghapus pengguna hotspot
					$API->write('/ppp/secret/remove', false);
					$API->write('=numbers=*' . $id); // Ganti '1' dengan nomor pengguna yang ingin Anda hapus
					$API->read();

					$name =  $this->input->post(
						'name',
						TRUE
					);
					$password =  $this->input->post('password', TRUE);
					$profile =  $this->input->post('profile', TRUE);
					// Kirim permintaan untuk menambahkan pengguna hotspot
					$API->comm("/ppp/secret/add", array(
						"service" => "any",
						"name" => "$name",
						"password" => "$password",
						"profile" => "$profile",
					));
					$getuser = $API->comm("/ppp/secret/print", array(
						"?name" => "$name",
					));
					$uid = $getuser[0]['.id'];
					// Tutup koneksi
					$API->disconnect();
					$data = array(
						'id' =>
						str_replace(
							"*",
							'',
							$uid
						),
						'name' => $this->input->post('name', TRUE),
						'password' => $this->input->post('password', TRUE),
						'service' => 'any',
						'profile' => $this->input->post('profile', TRUE),
						'is_aktive' => $this->input->post('is_aktive', TRUE),
					);

					$this->Ppp_model->update($this->input->post('id_ppp', TRUE), $data);
					$this->session->set_flashdata('message', 'Update Record Success');
					redirect(site_url('mikrotik/ppp'));
				}
			}
		}
	}

	public function delete($id)
	{
		$row = $this->Ppp_model->get_by_id($id);

		if ($row) {
			$rowMikrotik = $this->Mikrotik_model->get_by_aktive();
			if ($rowMikrotik) {
				$host = $rowMikrotik->ip_mikrotik;
				$username = $rowMikrotik->user_mikrotik;
				$password = $rowMikrotik->pass_mikrotik;
				// Buat objek RouterosAPI
				$API = new Mikweb();

				// Buat koneksi ke perangkat MikroTik
				if ($API->connect($host, $username, $password)) {
					// Kirim permintaan untuk menghapus pengguna hotspot
					$API->write('/ppp/secret/remove', false);
					$API->write('=numbers=*' . $row->id); // Ganti '1' dengan nomor pengguna yang ingin Anda hapus
					$response = $API->read();
					// Tutup koneksi
					$API->disconnect();
					$this->Ppp_model->delete($id);
					$this->session->set_flashdata('message', 'Delete Record Success');
					redirect(site_url('mikrotik/ppp'));
				}
			} else {
			}
		} else {
			$this->session->set_flashdata('message', 'a Not Found');
			redirect(site_url('mikrotik/ppp'));
		}
	}
	public function _rules()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		$this->form_validation->set_rules('profile', 'profile', 'trim|required');
		$this->form_validation->set_rules('is_aktive', 'is aktive', 'trim|required');

		// $this->form_validation->set_rules('id_username', 'id_username', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	public function excel()
	{
		$this->load->helper('exportexcel');
		$namaFile = "Ppp.xls";
		$judul = "Ppp";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Nama Ppp");
		xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
		xlsWriteLabel($tablehead, $kolomhead++, "User Ppp");
		xlsWriteLabel($tablehead, $kolomhead++, "Password Ppp");
		xlsWriteLabel($tablehead, $kolomhead++, "Ip Ppp");
		xlsWriteLabel($tablehead, $kolomhead++, "Domain");
		xlsWriteLabel($tablehead, $kolomhead++, "Is Aktive");
		xlsWriteLabel($tablehead, $kolomhead++, "Create Date");

		foreach ($this->Ppp_model->get_all() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteLabel($tablebody, $kolombody++, $data->Ppp);
			xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
			xlsWriteLabel($tablebody, $kolombody++, $data->user_Ppp);
			xlsWriteLabel($tablebody, $kolombody++, $data->pass_Ppp);
			xlsWriteLabel($tablebody, $kolombody++, $data->ip_Ppp);
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
		header("Content-Disposition: attachment;Filename=Ppp.doc");

		$data = array(
			'Ppp_data' => $this->Ppp_model->get_all(),
			'start' => 0
		);

		$this->load->view('Ppp/Ppp_doc', $data);
	}

	public function active()
	{
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->uri->segment(3));

		if ($q <> '') {
			$config['base_url'] = base_url() . 'index.php/mikrotik/ppp/index.html?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'index.php/mikrotik/ppp/index.html?q=' . urlencode($q);
		} else {
			$config['base_url'] = base_url() . 'index.php/mikrotik/ppp/index/';
			$config['first_url'] = base_url() . 'index.php/mikrotik/ppp/index/';
		}

		$config['per_page'] = 100;
		$config['page_query_string'] = FALSE;
		// $config['total_rows'] = $this->ppp_model->total_rows($q);
		// $ppp = $this->ppp_model->get_limit_data($config['per_page'], $start, $q);
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$row = $this->Mikrotik_model->get_by_aktive();
		if ($row) {
			$mikrotik = $row->id_mikrotik;
			$host = $row->ip_mikrotik;
			$username = $row->user_mikrotik;
			$password = $row->pass_mikrotik;

			$API = new Mikweb();
			if ($API->connect(
				$host,
				$username,
				$password
			)) {
				// ppp
				// $ppp = $API->comm('/ppp/active/getall');
				$API->write('/ppp/active/getall', false);
				$API->write('=.proplist=.id,name,service,address,uptime,comment');
				$ppp = $API->read();
				// $hostpot_data = $hostpot->result();
				// $result = json_encode($ppp);
				// echo $result;
				// die();
			}
		}
		usort($ppp, function ($a, $b) {
			return strcmp($a['uptime'], $b['uptime']);
		});

		$data = array(
			'ppp_data' => $ppp,
			'q' => $q,
			// 'total_rows' => $config['total_rows'],
			'start' => $start,
		);
		$this->template->load('template', 'ppp/ppp_active', $data);
	}
}

/* End of file Ppp.php */
/* Location: ./application/controllers/Ppp.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 21:45:15 */
/* http://harviacode.com */
