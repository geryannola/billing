<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model
{

    public $table = 'users';
    public $id = 'id_username';
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
    function total_rows($q = NULL) {
        $this->db->like('id_username', $q);
	$this->db->or_like('username', $q);
	$this->db->or_like('password', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('kota', $q);
	$this->db->or_like('provinsi', $q);
	$this->db->or_like('telepon', $q);
	$this->db->or_like('id_level', $q);
	$this->db->or_like('is_aktive', $q);
	$this->db->or_like('create_date', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_username', $q);
	$this->db->or_like('username', $q);
	$this->db->or_like('password', $q);
	$this->db->or_like('nama', $q);
	$this->db->or_like('email', $q);
	$this->db->or_like('alamat', $q);
	$this->db->or_like('kota', $q);
	$this->db->or_like('provinsi', $q);
	$this->db->or_like('telepon', $q);
	$this->db->or_like('id_level', $q);
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
        $this->db->from('users');
        $this->db->join('user_level', 'user_level.id_level = users.id_level');
        $this->db->where('id_username',$id);
        return $this->db->get()->row_array();
    }

}
