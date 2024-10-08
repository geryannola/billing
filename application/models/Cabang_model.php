<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cabang_model extends CI_Model
{

    public $table = 'cabang';
    public $id = 'id_cabang';
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
        $this->db->join('mikrotik', 'mikrotik.id_mikrotik = cabang.id_mikrotik');
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_cabang', $q);
        $this->db->or_like('nama_cabang', $q);
        $this->db->or_like('is_aktive', $q);
        $this->db->or_like('create_date', $q);
        $this->db->from($this->table);
        $this->db->join('mikrotik', 'mikrotik.id_mikrotik = cabang.id_mikrotik');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_cabang', $q);
        $this->db->or_like('nama_cabang', $q);
        $this->db->or_like('is_aktive', $q);
        $this->db->or_like('create_date', $q);
        $this->db->join('mikrotik', 'mikrotik.id_mikrotik = cabang.id_mikrotik');
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
        $this->db->from('cabang');
        $this->db->where('id_cabang', $id);
        return $this->db->get()->row_array();
    }
    public function tampil_cabang()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('cabang');
        $this->db->where('is_aktive', '1');
        return $this->db->get()->result_array();
    }
}