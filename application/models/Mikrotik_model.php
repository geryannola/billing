<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Mikrotik_model extends CI_Model
{

	public $table = 'mikrotik';
	public $id = 'id_mikrotik';
	public $order = 'DESC';

	function __construct()
	{
		parent::__construct();
		$this->load->library('Mikweb');

		// Inisialisasi objek RouterosAPI
		$this->Mikweb = new Mikweb();
	}

	// get all
	function get_all()
	{
		$this->db->order_by($this->id, $this->order);
		return $this->db->get($this->table)->result();
	}

	// get data by id
	function get_by_id($id)
	{
		$this->db->where($this->id, $id);
		return $this->db->get($this->table)->row();
	}

	// get total rows
	function total_rows($q = NULL)
	{
		$this->db->like('id_mikrotik', $q);
		$this->db->or_like('mikrotik', $q);
		$this->db->or_like('is_aktive', $q);
		$this->db->or_like('create_date', $q);
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	// get data with limit and search
	function get_limit_data($limit, $start = 0, $q = NULL)
	{
		$this->db->order_by($this->id, $this->order);
		$this->db->like('id_mikrotik', $q);
		$this->db->or_like('mikrotik', $q);
		$this->db->or_like('is_aktive', $q);
		$this->db->or_like('create_date', $q);
		$this->db->limit($limit, $start);
		return $this->db->get($this->table)->result();
	}

	// insert data
	function insert($data)
	{
		$this->db->insert($this->table, $data);
	}

	// update data
	function update($id, $data)
	{
		$this->db->where($this->id, $id);
		$this->db->update($this->table, $data);
	}

	// delete data
	function delete($id)
	{
		$this->db->where($this->id, $id);
		$this->db->delete($this->table);
	}
	public function edit_data($id)
	{
		$this->db->from('mikrotik');
		$this->db->where('id_mikrotik', $id);
		return $this->db->get()->row_array();
	}
	public function tampil_route()
	{
		$result = array();
		$this->db->select('*');
		$this->db->from('mikrotik');
		$this->db->where('is_aktive', '1');
		return $this->db->get()->result_array();
	}

	function toggleAllStatus()
	{
		// Lakukan query update tanpa kondisi WHERE
		$this->db->set('is_aktive', 'IF(is_aktive="1", "2", "1")', FALSE);
		$this->db->update($this->table);
	}

	// get data by id
	function get_by_aktive()
	{
		$this->db->where('is_aktive', '1');
		return $this->db->get($this->table)->row();
	}

	// Metode untuk membuat koneksi ke perangkat MikroTik
	public function connect($host, $username, $password)
	{
		return $this->Mikweb->connect($host, $username, $password);
	}

	// Metode untuk menutup koneksi ke perangkat MikroTik
	public function disconnect()
	{
		$this->Mikweb->disconnect();
	}

	// Metode untuk menambahkan profil hotspot
	public function addHotspotProfile($profileName, $rateLimit, $parentQueue, $sharedUsers)
	{
		// Kirim permintaan untuk menambahkan profil hotspot
		$this->Mikweb->write('/ip/hotspot/profile/add', false);
		$this->Mikweb->write('=name=' . $profileName, false);
		$this->Mikweb->write('=rate-limit=' . $rateLimit, false);
		$this->Mikweb->write('=parent-queue=' . $parentQueue, false);
		$this->Mikweb->write('=shared-users=' . $sharedUsers, false);
		$response = $this->Mikweb->read();

		return $response;
	}
}
