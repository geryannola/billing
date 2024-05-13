<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class PppProfile_model extends CI_Model
{

	public $table = 'profile_ppp';
	public $id = 'id_profile_ppp';
	public $order = 'ASC';

	function __construct()
	{
		parent::__construct();
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
		$this->db->like('name', $q);
		$this->db->from($this->table);
		$this->db->join('mikrotik', 'mikrotik.id_mikrotik = profile_ppp.id_mikrotik');
		$this->db->where('mikrotik.is_aktive', 1);
		return $this->db->count_all_results();
	}

	// get data with limit and search
	function get_limit_data($limit, $start = 0, $q = NULL)
	{
		$this->db->order_by($this->id, $this->order);
		$this->db->like('name', $q);
		$this->db->join('mikrotik', 'mikrotik.id_mikrotik = profile_ppp.id_mikrotik');
		$this->db->where('mikrotik.is_aktive', 1);
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
		$this->db->where('id', $id);
		$this->db->update($this->table, $data);
	}
	// update data
	function updateMIkrotik($id, $id_mikrotik, $data)
	{
		$this->db->where('id', $id);
		$this->db->where('id_mikrotik', $id_mikrotik);
		$this->db->update($this->table, $data);
	}

	// delete data
	function delete($id)
	{
		$this->db->where($this->id, $id);
		$this->db->delete($this->table);
	}

	public function check($id, $id_mikrotik)
	{
		$this->db->from($this->table);
		$this->db->where('id', '*' . $id);
		$this->db->where('id_mikrotik', $id_mikrotik);
		return $this->db->get()->num_rows();
	}

	public function tampil_profilePpp()
	{
		$result = array();
		$this->db->select('*');
		$this->db->from('profile_ppp');
		$this->db->join('mikrotik', 'mikrotik.id_mikrotik = profile_ppp.id_mikrotik');
		$this->db->where('mikrotik.is_aktive', '1');
		return $this->db->get()->result_array();
	}
}
