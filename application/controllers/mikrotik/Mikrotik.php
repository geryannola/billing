<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Mikrotik extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		check_not_login();
		check_admin();
		$this->load->model('Mikrotik_model');
		$this->load->model('MikrotikUser_model');
		$this->load->model('MikrotikProfile_model');
		// $this->load->model('Ppp_model');
		// $this->load->model('PppProfile_model');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$q = urldecode($this->input->get('q', TRUE));
		$start = intval($this->uri->segment(3));

		if ($q <> '') {
			$config['base_url'] = base_url() . 'index.php/Route/index.html?q=' . urlencode($q);
			$config['first_url'] = base_url() . 'index.php/Route/index.html?q=' . urlencode($q);
		} else {
			$config['base_url'] = base_url() . 'index.php/Route/index/';
			$config['first_url'] = base_url() . 'index.php/Route/index/';
		}

		$config['per_page'] = 10;
		$config['page_query_string'] = FALSE;
		$config['total_rows'] = $this->Mikrotik_model->total_rows($q);
		$mikrotik = $this->Mikrotik_model->get_limit_data($config['per_page'], $start, $q);
		$config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
		$config['full_tag_close'] = '</ul>';
		$this->load->library('pagination');
		$this->pagination->initialize($config);

		$data = array(
			'mikrotik_data' => $mikrotik,
			'q' => $q,
			'pagination' => $this->pagination->create_links(),
			'total_rows' => $config['total_rows'],
			'start' => $start,
		);
		$this->template->load('template', 'mikrotik/mikrotik_list', $data);
	}

	public function read($id)
	{
		$row = $this->Mikrotik_model->get_by_id($id);
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
				// Hostpot
				$API->write('/ip/hotspot/user/print', false);
				$API->write('=.proplist=.id,server,name,password,profile,comment,disabled');
				$hostpot = $API->read();
				// $result = json_encode($hostpot);
				// echo $result;
				// die();
				foreach ($hostpot as $user) {
					$id_hostpot =  str_replace("*", '', $user[".id"]);

					if (isset($user['comment'])) {
						// Lakukan sesuatu dengan nilai $array['default']
						$comment = $user["comment"];
					} else {
						$comment = '-';
					}
					if (isset($user['server'])) {
						$server = $user["server"];
					} else {
						$server = 'all';
					}
					if (isset($user['password'])) {
						$password = $user["password"];
					} else {
						$password = '-';
					}
					if (isset($user['profile'])) {
						$profile = $user["profile"];
					} else {
						$profile = '-';
					}
					if ($this->MikrotikUser_model->checkHostpot($id_hostpot, $id) == 0) {
						$data_hostpot = array(
							'id' => str_replace("*", '', $user[".id"]),
							'service' => 'hostpot',
							'server' => $server,
							'name' => $user["name"],
							'password' => $password,
							'profile' => $profile,
							'disabled' => $user["disabled"],
							'comment' => $comment,
							'id_mikrotik' => $mikrotik,
							'is_aktive' => 1,
							'create_date' => date('y-m-d H:i:s')
						);
						$this->MikrotikUser_model->insert($data_hostpot);
					} else {
						$data_hostpot = array(
							'id' => str_replace("*", '', $user[".id"]),
							'server' => $server,
							'name' => $user["name"],
							'password' => $password,
							'profile' => $profile,
							'disabled' => $user["disabled"],
							'comment' => $comment,
							'id_mikrotik' => $mikrotik,
							'is_aktive' => 1,
							'create_date' => date('y-m-d H:i:s')
						);
						$this->MikrotikUser_model->updateMikrotik($id_hostpot, $mikrotik, $data_hostpot);
					}
				}
				// PROFILE HOSTPOT
				$API->write('/ip/hotspot/user/profile/print', false);
				$API->write('=.proplist=.id,name,shared-users,rate-limit,parent-queue');
				$hostpotprofile = $API->read();
				// $result = json_encode($hostpotprofile);
				// echo $result;
				// die();
				foreach ($hostpotprofile as $p) {
					$id_profile_hostpot = str_replace("*", '', $p[".id"]);
					if (isset($p['rate-limit'])) {
						$rate_limit = $p["rate-limit"];
					} else {
						$rate_limit = '-';
					}
					if (isset($p['parent-queue'])) {
						$parent_queue = $p["parent-queue"];
					} else {
						$parent_queue = '-';
					}
					if ($this->MikrotikProfile_model->checkHostpot($id_profile_hostpot, $id) == 0) {
						$data_hostpot = array(
							'id' => str_replace("*", '', $p[".id"]),
							'service' => 'hostpot',
							'name' => $p["name"],
							'shared_users' => $p["shared-users"],
							'rate_limit' => $rate_limit,
							'parent_queue' => $parent_queue,
							'id_mikrotik' => $mikrotik,
							'is_aktive' => 1,
							'create_date' => date('y-m-d H:i:s')
						);
						$this->MikrotikProfile_model->insert($data_hostpot);
					} else {
						$data_hostpot = array(
							'id' => str_replace("*", '', $p[".id"]),
							'name' => $p["name"],
							'shared_users' => $p["shared-users"],
							'rate_limit' => $rate_limit,
							'parent_queue' => $parent_queue,
							'id_mikrotik' => $mikrotik,
							'is_aktive' => 1,
							'create_date' => date('y-m-d H:i:s')
						);
						$this->MikrotikProfile_model->updateMikrotik($id_profile_hostpot, $mikrotik, $data_hostpot);
					}
				}

				// PPP PROFILE
				$API->write('/ppp/profile/print', false);
				$API->write('=.proplist=.id,name,local-address,remote-address,only-one,rate-limit');
				$pppProfile = $API->read();
				// $result = json_encode($pppProfile);
				// echo $result;
				// die();
				foreach ($pppProfile as $p) {
					$id_ppp = str_replace("*", '', $p[".id"]);
					if (isset($user['local-address'])) {
						$local_address = $user["local-address"];
					} else {
						$local_address = '-';
					}
					if (isset($user['remote-address'])) {
						$remote_address = $user["remote-address"];
					} else {
						$remote_address = '-';
					}
					if (isset($user['rate-limit'])) {
						$rate_limit = $user["rate-limit"];
					} else {
						$rate_limit = '-';
					}
					if ($this->MikrotikProfile_model->checkPpp($id_ppp, $id) == 0) {
						$data_hostpot = array(
							'id' => str_replace("*", '', $p[".id"]),
							'service' => 'ppp',
							'name' => $p["name"],
							'local_address' => $local_address,
							'remote_address' => $remote_address,
							'rate_limit' => $rate_limit,
							'id_mikrotik' => $mikrotik,
							'is_aktive' => 1,
							'create_date' => date('y-m-d H:i:s')
						);
						$this->MikrotikProfile_model->insert($data_hostpot);
					} else {
						$data_hostpot = array(
							'id' => str_replace("*", '', $p[".id"]),
							'name' => $p["name"],
							'local_address' => $local_address,
							'remote_address' => $remote_address,
							'rate_limit' => $rate_limit,
							'id_mikrotik' => $mikrotik,
							'is_aktive' => 1,
							'create_date' => date('y-m-d H:i:s')
						);
						$this->MikrotikProfile_model->updateMIkrotik($id_ppp, $mikrotik, $data_hostpot);
					}
				}

				// PPP
				$API->write('/ppp/secret/print', false);
				$API->write('=.proplist=.id,name,service,password,profile,local-address,remote-address');
				$ppp = $API->read();
				// $result = json_encode($ppp);
				// echo $result;
				// die();
				foreach ($ppp as $p) {
					$id_ppp = str_replace("*", '', $p[".id"]);

					if ($this->MikrotikUser_model->checkPpp($id_ppp, $id) == 0) {
						$data_hostpot = array(
							'id' => str_replace("*", '', $p[".id"]),
							'name' => $p["name"],
							'service' => $p["service"],
							'password' => $p["password"],
							'profile' => $p["profile"],
							'local_address' => $p["local-address"],
							'remote_address' => $p["remote-address"],
							'id_mikrotik' => $mikrotik,
							'is_aktive' => 1,
							'create_date' => date('y-m-d H:i:s')
						);
						$this->MikrotikUser_model->insert($data_hostpot);
					} else {
						$data_hostpot = array(
							'id' => str_replace("*", '', $p[".id"]),
							'name' => $p["name"],
							'service' => $p["service"],
							'password' => $p["password"],
							'profile' => $p["profile"],
							'local_address' => $p["local-address"],
							'remote_address' => $p["remote-address"],
							'id_mikrotik' => $mikrotik,
							'is_aktive' => 1,
							'create_date' => date('y-m-d H:i:s')
						);
						$this->MikrotikUser_model->updateMikrotik($id_ppp, $mikrotik, $data_hostpot);
					}
				}
				$API->disconnect();
				redirect(site_url('mikrotik/mikrotik'));
			} else {
				redirect(site_url('mikrotik/mikrotik'));
			}
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('mikrotik/mikrotik'));
		}
	}

	public function create()
	{
		$data = array(
			'button' => 'Create',
			'action' => site_url('mikrotik/mikrotik/create_action'),
			'id_mikrotik' => set_value('id_mikrotik'),
			'mikrotik' => set_value('mikrotik'),
			'user_mikrotik' => set_value('user_mikrotik'),
			'pass_mikrotik' => set_value('pass_mikrotik'),
			'ip_mikrotik' => set_value('ip_mikrotik'),
			'is_aktive' => set_value('is_aktive'),
			'create_date' => set_value('create_date'),
		);
		// $data['coba'] = $this->Route_level_model->tampil_level();
		$this->template->load('template', 'mikrotik/mikrotik/mikrotik_form', $data);
	}

	public function create_action()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$data = array(
				'Route' => $this->input->post('Route', TRUE),
				'alamat' => $this->input->post('alamat', TRUE),
				'user_Route' => $this->input->post('user_Route', TRUE),
				'pass_Route' => $this->input->post('pass_Route', TRUE),
				'ip_Route' => $this->input->post('ip_Route', TRUE),
				'domain' => $this->input->post('domain', TRUE),
				'is_aktive' => $this->input->post('is_aktive', TRUE),
				'create_date' => date('y-m-d H:i:s')
			);

			$this->Mikrotik_model->insert($data);
			$this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('mikrotik/mikrotik'));
		}
	}

	public function update($id)
	{
		$row = $this->Mikrotik_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('Route/update_action'),
				'id_mikrotik' => set_value('id_mikrotik', $row->id_mikrotik),
				'Route' => set_value('Route', $row->Route),
				'alamat' => set_value('alamat', $row->alamat),
				'user_Route' => set_value('user_Route', $row->user_Route),
				'pass_Route' => set_value('pass_Route', $row->pass_Route),
				'ip_Route' => set_value('ip_Route', $row->ip_Route),
				'domain' => set_value('domain', $row->domain),
				'is_aktive' => set_value('is_aktive', $row->is_aktive),
				'create_date' => set_value('create_date', $row->create_date),
			);
			// $data['coba'] = $this->Route_level_model->tampil_level();
			$data['data_Route'] = $this->Mikrotik_model->edit_data($id);
			$this->template->load('template', 'mikrotik/mikrotik_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('mikrotik/mikrotik'));
		}
	}

	public function update_action()
	{
		$this->_rules();
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id_mikrotik', TRUE));
		} else {
			$data = array(
				'mikrotik' => $this->input->post('mikrotik', TRUE),
				'user_mikrotik' => $this->input->post('user_mikrotik', TRUE),
				'pass_mikrotik' => $this->input->post('pass_mikrotik', TRUE),
				'ip_mikrotik' => $this->input->post('ip_mikrotik', TRUE),
				'is_aktive' => $this->input->post('is_aktive', TRUE),
			);
			$this->Mikrotik_model->update($this->input->post('id_mikrotik', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('mikrotik/mikrotik'));
		}
	}

	public function delete($id)
	{
		$row = $this->Mikrotik_model->get_by_id($id);

		if ($row) {
			$this->Mikrotik_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('mikrotik/mikrotik'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('mikrotik/mikrotik'));
		}
	}
	public function is_aktif($id)
	{
		$row = $this->Mikrotik_model->get_by_id($id);

		if ($row) {
			$this->Mikrotik_model->toggleAllStatus();

			$this->session->set_flashdata('message', 'Route yang aktif ' . $row->mikrotik);
			redirect(site_url('mikrotik/mikrotik'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('mikrotik/mikrotik'));
		}
	}
	public function _rules()
	{

		$this->form_validation->set_rules('mikrotik', 'mikrotik', 'trim|required');
		$this->form_validation->set_rules('user_mikrotik', 'user_mikrotik', 'trim|required');
		$this->form_validation->set_rules('pass_mikrotik', 'pass_mikrotik', 'trim|required');
		$this->form_validation->set_rules('ip_mikrotik', 'ip_mikrotik', 'trim|required');
		$this->form_validation->set_rules('is_aktive', 'is aktive', 'trim|required');

		// $this->form_validation->set_rules('id_username', 'id_username', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}

	public function excel()
	{
		$this->load->helper('exportexcel');
		$namaFile = "Route.xls";
		$judul = "Route";
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
		xlsWriteLabel($tablehead, $kolomhead++, "Nama Route");
		xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
		xlsWriteLabel($tablehead, $kolomhead++, "User Route");
		xlsWriteLabel($tablehead, $kolomhead++, "Password Route");
		xlsWriteLabel($tablehead, $kolomhead++, "Ip Route");
		xlsWriteLabel($tablehead, $kolomhead++, "Domain");
		xlsWriteLabel($tablehead, $kolomhead++, "Is Aktive");
		xlsWriteLabel($tablehead, $kolomhead++, "Create Date");

		foreach ($this->Mikrotik_model->get_all() as $data) {
			$kolombody = 0;

			//ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
			xlsWriteNumber($tablebody, $kolombody++, $nourut);
			xlsWriteLabel($tablebody, $kolombody++, $data->Route);
			xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
			xlsWriteLabel($tablebody, $kolombody++, $data->user_Route);
			xlsWriteLabel($tablebody, $kolombody++, $data->pass_Route);
			xlsWriteLabel($tablebody, $kolombody++, $data->ip_Route);
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
		header("Content-Disposition: attachment;Filename=Route.doc");

		$data = array(
			'Route_data' => $this->Mikrotik_model->get_all(),
			'start' => 0
		);

		$this->load->view('Route/Route_doc', $data);
	}
}

/* End of file Route.php */
/* Location: ./application/controllers/Route.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 21:45:15 */
/* http://harviacode.com */