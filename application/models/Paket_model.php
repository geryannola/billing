<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Paket_model extends CI_Model
{

    public $table = 'paket';
    public $id = 'id_paket';
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
    function total_rows($q = NULL, $bisnis)
    {
        $this->db->like('id_paket', $q);
        $this->db->or_like('nama_paket', $q);
        $this->db->or_like('paket.create_date', $q);
        $this->db->from($this->table);
        $this->db->join('mikrotik', 'mikrotik.id_mikrotik = paket.id_mikrotik');
        $this->db->where('paket.id_bisnis', $bisnis);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL,$bisnis)
    {
        $this->db->select('*');
        $this->db->select('paket.is_aktive');
        // $this->db->select('paket.create_date');
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_paket', $q);
        $this->db->or_like('nama_paket', $q);
        $this->db->or_like('paket.create_date', $q);
		$this->db->join('mikrotik', 'mikrotik.id_mikrotik = paket.id_mikrotik');
        $this->db->where('paket.id_bisnis', $bisnis);
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
        $this->db->from('paket');
        $this->db->where('id_paket', $id);
        return $this->db->get()->row_array();
    }
    public function tampil_paket()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('paket');
        $this->db->where('is_aktive', '1');
        return $this->db->get()->result_array();
    }
}