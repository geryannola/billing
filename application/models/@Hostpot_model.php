<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Hostpot_model extends CI_Model
{

	public $table = 'hostpot';
	public $id = 'id_hostpot';
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
		$this->db->select('*');
		$this->db->select('hostpot.is_aktive');
		$this->db->where($this->id, $id);
		return $this->db->get($this->table)->row();
	}

	// get total rows
	function total_rows($q = NULL)
	{
		$this->db->select('*');
		$this->db->select('hostpot.is_aktive');
		$this->db->like('hostpot.name', $q);
		$this->db->from($this->table);
		$this->db->join('mikrotik', 'mikrotik.id_mikrotik = hostpot.id_mikrotik');
		$this->db->where('mikrotik.is_aktive', 1);
		return $this->db->count_all_results();
	}

	// get data with limit and search
	function get_limit_data($limit, $start = 0, $q = NULL)
	{
		$this->db->select('*');
		$this->db->select('hostpot.is_aktive');
		$this->db->order_by($this->id, $this->order);
		$this->db->like('hostpot.name', $q);
		$this->db->join('mikrotik', 'mikrotik.id_mikrotik = hostpot.id_mikrotik');
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
	function updateMikrotik($id, $route, $data)
	{
		$this->db->where('id', $id);
		$this->db->where('id_mikrotik', $route);
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
		$this->db->where($this->id, $id);
		return $this->db->get()->row_array();
	}

	public function tampil_hostpot()
	{
		$result = array();
		$this->db->select('*');
		$this->db->from('hostpot');
		$this->db->where('is_aktive', '1');
		return $this->db->get()->result_array();
	}

	public function check($id, $id_mikrotik)
	{
		$this->db->from($this->table);
		$this->db->where('id', $id);
		$this->db->where('id_mikrotik', $id_mikrotik);
		return $this->db->get()->num_rows();
	}
}
