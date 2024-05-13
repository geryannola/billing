<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PppProfile extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		check_not_login();
		check_admin();

		$this->load->model('PppProfile_model');
		$this->load->model('Mikrotik_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->uri->segment(3));

		if ($q <> '') {
			$config['base_url'] = base_url() . 'index.php/mikrotik/PppProfile/index.html?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'index.php/mikrotik/PppProfile/index.html?q=' . urlencode($q);
		} else {
			$config['base_url'] = base_url() . 'index.php/mikrotik/PppProfile/index/';
			$config['first_url'] = base_url() . 'index.php/mikrotik/PppProfile/index/';
		}

		$config['per_page'] = 100;
		$config['page_query_string'] = FALSE;
		$config['total_rows'] = $this->PppProfile_model->total_rows($q);
		$PppProfile = $this->PppProfile_model->get_limit_data($config['per_page'], $start, $q);
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'hostpot_data' => $PppProfile,
			'q' => $q,
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
		);
		$this->template->load('template', 'PppProfile/PppProfile_list', $data);
	}

	// public function read($id)
	// {
	// 	$row = $this->PppProfile_model->get_by_id($id);
	// 	if ($row) {
	// 		$PppProfile = $row->id_PppProfile;
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
	// 			// PppProfile
	// 			$API->write('/ip/hotspot/user/print');
	// 			$users = $API->read();
	// 			foreach ($users as $user) {
	// 				$id_profile_hostpot = $user[".id"];
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
	// 				if ($this->PppProfile_model->check($id_profile_hostpot, $id) == 0) {
	// 					$data_hostpot = array(
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
	// 						'id_PppProfile' => $PppProfile,
	// 						'is_aktive' => 1,
	// 						'create_date' => date('y-m-d H:i:s')
	// 					);
	// 					$this->PppProfile_model->insert($data_hostpot);
	// 				} else {
	// 					$data_hostpot = array(
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
	// 						'id_PppProfile' => $PppProfile,
	// 						'is_aktive' => 1,
	// 						'create_date' => date('y-m-d H:i:s')
	// 					);
	// 					$this->PppProfile_model->update($id_profile_hostpot, $PppProfile, $data_hostpot);
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
	// 					$data_hostpot = array(
	// 						'id' => $p[".id"],
	// 						'name' => $p["name"],
	// 						'service' => $p["service"],
	// 						'caller-id' => $caller_id,
	// 						'password' => $p["password"],
	// 						'profile' => $p["profile"],
	// 						'local-address' => $p["local-address"],
	// 						'remote-address' => $p["remote-address"],
	// 						'PppProfiles' => $p["PppProfiles"],
	// 						'limit-bytes-in' => $p["limit-bytes-in"],
	// 						'limit-bytes-out' => $p["limit-bytes-out"],
	// 						'last-logged-out' => $last_logged_out,
	// 						'last-caller-id' => $last_caller_id,
	// 						'last-disconnect-reason' => $p["last-disconnect-reason"],
	// 						'disabled' => $p["disabled"],
	// 						'id_PppProfile' => $PppProfile,
	// 						'is_aktive' => 1,
	// 						'create_date' => date('y-m-d H:i:s')
	// 					);
	// 					$this->Ppp_model->insert($data_hostpot);
	// 				} else {
	// 					$data_hostpot = array(
	// 						'id' => $p[".id"],
	// 						'name' => $p["name"],
	// 						'service' => $p["service"],
	// 						'caller-id' => $caller_id,
	// 						'password' => $p["password"],
	// 						'profile' => $p["profile"],
	// 						'local-address' => $p["local-address"],
	// 						'remote-address' => $p["remote-address"],
	// 						'PppProfiles' => $p["PppProfiles"],
	// 						'limit-bytes-in' => $p["limit-bytes-in"],
	// 						'limit-bytes-out' => $p["limit-bytes-out"],
	// 						'last_logged_out' => $last_logged_out,
	// 						'last-caller-id' => $last_caller_id,
	// 						'last-disconnect-reason' => $p["last-disconnect-reason"],
	// 						'disabled' => $p["disabled"],
	// 						'id_PppProfile' => $PppProfile,
	// 						'is_aktive' => 1,
	// 						'create_date' => date('y-m-d H:i:s')
	// 					);
	// 					$this->Ppp_model->update($id_ppp, $PppProfile, $data_hostpot);
	// 				}
	// 			}
	// 			$API->disconnect();
	// 			redirect(site_url('mikrotik/PppProfile'));
	// 		} else {
	// 			redirect(site_url('mikrotik/PppProfile'));
	// 		}
	// 	} else {
	// 		$this->session->set_flashdata('message', 'Record Not Found');
	// 		redirect(site_url('mikrotik/PppProfile'));
	// 	}
	// }

	public function create()
	{
		$data = array(
			'button' => 'Create',
			'action' => site_url('mikrotik/hostpotProfile/create_action'),
			'id_profile_hostpot' => set_value('id_profile_hostpot'),
			'name' => set_value('name`'),
			'shared_users' => set_value('shared_users'),
			'rate_limit' => set_value('rate_limit'),
			'is_aktive' => set_value('is_aktive'),
			'create_date' => set_value('create_date')
		);
		$data['parent_queue'] = $this->PppProfile_model->tampil_parentQueue();
		$this->template->load('template', 'hostpotProfile/hostpotProfile_form', $data);
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
				if ($API->connect(
					$host,
					$username,
					$password
				)) {
					$name =  $this->input->post('name', TRUE);
					$shared_users =  $this->input->post('shared_users', TRUE);
					$rate_limit =  $this->input->post('rate_limit', TRUE);
					$parent_queue =  $this->input->post('parent_queue', TRUE);
					// Kirim permintaan untuk menambahkan pengguna hotspot

					$API->comm("/ip/hotspot/user/profile/add", array(
						/*"add-mac-cookie" => "yes",*/
						"name" => "$name",
						"rate-limit" => "$rate_limit",
						"shared-users" => "$shared_users",
						"status-autorefresh" => "1m",
						"transparent-proxy" => "yes",
						"parent-queue" => "$parent_queue"
					));

					$getprofile = $API->comm("/ip/hotspot/user/profile/print", array(
						"?name" => "$name",
					));
					$pid = $getprofile[0]['.id'];
					// Tutup koneksi
					$this->Mikrotik_model->disconnect();
					// Melakukan koneksi ke perangkat MikroTik


					$data = array(
						'id' => $uid,
						'name' => $this->input->post('name', TRUE),
						'shared_users' => $this->input->post('shared_users', TRUE),
						'rate_limit' => $this->input->post('rate_limit', TRUE),
						'parent_queue' => $this->input->post('parent_queue', TRUE),
						'id_mikrotik' => $row->id_mikrotik,
						'is_aktive' => $this->input->post('is_aktive', TRUE),
						'create_date' => date('y-m-d H:i:s')
					);

					$this->PppProfile_model->insert($data);
					$this->session->set_flashdata('message', 'Create Record Success');
					redirect(site_url('mikrotik/hostpotProfile'));
				} else {
					redirect(site_url('mikrotik/hostpotProfile'));
				}
			} else {
				redirect(site_url('mikrotik/hostpotProfile'));
			}
		}
	}

	public function update($id)
	{
		$row = $this->PppProfile_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('hostpot/update_action'),
				'id_profile_hostpot' => set_value('id_profile_hostpot', $row->id_profile_hostpot),
				'hostpot' => set_value('hostpot', $row->hostpot),
				'alamat' => set_value('alamat', $row->alamat),
				'user_hostpot' => set_value('user_hostpot', $row->user_hostpot),
				'pass_hostpot' => set_value('pass_hostpot', $row->pass_hostpot),
				'ip_hostpot' => set_value('ip_hostpot', $row->ip_hostpot),
				'domain' => set_value('domain', $row->domain),
				'is_aktive' => set_value('is_aktive', $row->is_aktive),
				'create_date' => set_value('create_date', $row->create_date),
			);
			// $data['coba'] = $this->hostpot_level_model->tampil_level();
			$data['data_hostpot'] = $this->PppProfile_model->edit_data($id);
			$this->template->load('template', 'hostpot/hostpotProfile_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('mikrotik/hostpotProfile'));
		}
	}

	public function update_action()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id_profile_hostpot', TRUE));
		} else {
			$data = array(
				'hostpot' => $this->input->post('hostpot', TRUE),
				'alamat' => $this->input->post('alamat', TRUE),
				'user_hostpot' => $this->input->post('user_hostpot', TRUE),
				'pass_hostpot' => $this->input->post('pass_hostpot', TRUE),
				'ip_hostpot' => $this->input->post('ip_hostpot', TRUE),
				'domain' => $this->input->post('domain', TRUE),
				'is_aktive' => $this->input->post('is_aktive', TRUE),
			);


			$this->PppProfile_model->update($this->input->post('id_profile_hostpot', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('mikrotik/hostpotProfile'));
		}
	}

	public function delete($id)
	{
		$row = $this->PppProfile_model->get_by_id($id);

		if ($row) {
			$this->PppProfile_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('mikrotik/hostpotProfile'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('mikrotik/hostpotProfile'));
		}
	}
	public function _rules()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('shared_users', 'shared_users', 'trim|required');
		$this->form_validation->set_rules('rate_limit', 'rate_limit', 'trim|required');
		$this->form_validation->set_rules('is_aktive', 'is aktive', 'trim|required');

		// $this->form_validation->set_rules('id_username', 'id_username', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	public function excel()
	{
		$this->load->helper('exportexcel');
		$namaFile = "PppProfile.xls";
		$judul = "PppProfile";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Nama PppProfile");
		xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
		xlsWriteLabel($tablehead, $kolomhead++, "User PppProfile");
		xlsWriteLabel($tablehead, $kolomhead++, "Password PppProfile");
		xlsWriteLabel($tablehead, $kolomhead++, "Ip PppProfile");
		xlsWriteLabel($tablehead, $kolomhead++, "Domain");
		xlsWriteLabel($tablehead, $kolomhead++, "Is Aktive");
		xlsWriteLabel($tablehead, $kolomhead++, "Create Date");

		foreach ($this->PppProfile_model->get_all() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteLabel($tablebody, $kolombody++, $data->PppProfile);
			xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
			xlsWriteLabel($tablebody, $kolombody++, $data->user_PppProfile);
			xlsWriteLabel($tablebody, $kolombody++, $data->pass_PppProfile);
			xlsWriteLabel($tablebody, $kolombody++, $data->ip_PppProfile);
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
		header("Content-Disposition: attachment;Filename=PppProfile.doc");

		$data = array(
			'PppProfile_data' => $this->PppProfile_model->get_all(),
			'start' => 0
		);

		$this->load->view('PppProfile/PppProfile_doc', $data);
	}
}

/* End of file PppProfile.php */
/* Location: ./application/controllers/PppProfile.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 21:45:15 */
/* http://harviacode.com */
