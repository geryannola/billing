<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelanggan_model extends CI_Model
{

    public $table = 'pelanggan';
    public $id = 'id_pelanggan';
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
        $this->db->select('*, pelanggan.alamat');
        $this->db->from('pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->where($this->id, $id);
        return $this->db->get()->row();

        //   $this->db->from('pelanggan');
        // $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        // $this->db->where('id_pelanggan',$id);
        // return $this->db->get()->row_array();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_pelanggan', $q);
        $this->db->or_like('nama_pelanggan', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*, pelanggan.alamat');
        $this->db->order_by('pelanggan.id_cabang', $this->id, $this->order);
        $this->db->like('id_pelanggan', $q);
        $this->db->or_like('nama_pelanggan', $q);
        $this->db->from('pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
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
        $this->db->from('pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->where('id_pelanggan', $id);
        return $this->db->get()->row_array();
    }
    public function tampil_pelanggan()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        return $this->db->get()->result_array();
    }
}

/* End of file User_level_model.php */
/* Location: ./application/models/User_level_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 18:40:20 */
/* http://harviacode.com */