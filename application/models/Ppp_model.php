<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Ppp_model extends CI_Model
{

	public $table = 'ppp';
	public $id = 'id_ppp';
	public $order = 'DESC';

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
		$this->db->join('mikrotik', 'mikrotik.id_mikrotik = ppp.id_mikrotik');
		$this->db->where('mikrotik.is_aktive', 1);
		return $this->db->count_all_results();
	}

	// get data with limit and search
	function get_limit_data($limit, $start = 0, $q = NULL)
	{
		$this->db->order_by($this->id, $this->order);
		$this->db->like('name', $q);
		$this->db->join('mikrotik', 'mikrotik.id_mikrotik = ppp.id_mikrotik');
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
		$this->db->where($this->id, $id);
		$this->db->update($this->table, $data);
	}
	// update data
	function updateMikrotik($id, $id_mikrotik, $data)
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
	public function edit_data($id)
	{
		$this->db->from($this->table);
		$this->db->where('id_ppp', $id);
		return $this->db->get()->row_array();
	}


	public function check($id, $id_mikrotik)
	{
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$this->db->where('id_mikrotik', $id_mikrotik);
		return $this->db->get()->num_rows();
	}
}
