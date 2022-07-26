<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kas_masuk_model extends CI_Model
{

    public $table = 'kas_masuk';
    public $id = 'id_km';
    public $jenis = 'jenis';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->where($this->jenis, 'Masuk');
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
        //        $this->db->like('id_km', $q);
        // $this->db->or_like('tgl_km', $q);
        // $this->db->or_like('uraian_km', $q);
        // $this->db->or_like('masuk', $q);
        // $this->db->or_like('keluar', $q);
        // $this->db->or_like('jenis', $q);
        $this->db->where('jenis', 'Masuk');
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $masuk = 'Masuk';
        $this->db->order_by($this->id, $this->order);
        //        $this->db->like('id_km', $q);
        // $this->db->or_like('tgl_km', $q);
        // $this->db->or_like('uraian_km', $q);
        // $this->db->or_like('masuk', $q);
        // $this->db->or_like('keluar', $q);
        // $this->db->or_like('jenis', $q);
        $this->db->where('jenis', $masuk);
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
    public function tampil_bayar()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('cara_bayar');
        return $this->db->get()->result_array();
    }
}

/* End of file kas_masuk_model.php */
/* Location: ./application/models/kas_masuk_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-22 17:57:40 */
/* http://harviacode.com */