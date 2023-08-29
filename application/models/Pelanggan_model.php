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
        $this->db->order_by('pelanggan.id_pelanggan', $this->order);
        $this->db->select('*', 'pelanggan.alamat', 'pelanggan.is_aktive');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        return $this->db->get($this->table)->result();
    }

    function get_all_cabang($id)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->select('*', 'pelanggan.alamat', 'pelanggan.is_aktive');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        $this->db->where('pelanggan.is_aktive', '1');
        $this->db->where('pelanggan.id_cabang', $id);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->from('pelanggan');
        $this->db->select('*');

        $this->db->where($this->id, $id);
        return $this->db->get()->row();
    }

    // get data by id
    function get_by_id_rincian($id)
    {
        $this->db->from('pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        $this->db->select('*');

        $this->db->where($this->id, $id);
        return $this->db->get()->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_pelanggan', $q);
        $this->db->or_like('nama_pelanggan', $q);
        $this->db->or_like('pelanggan.alamat', $q);
        $this->db->or_like('cabang', $q);
        $this->db->or_like('nama_paket', $q);
        $this->db->from($this->table);
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        return $this->db->count_all_results();
    }

    function total_rows_riwayat($id, $q = NULL)
    {
        $this->db->from('tagihan');
        $this->db->where('id_pelanggan', $id);
        $this->db->where('status_bayar', 'Y');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->select('*, pelanggan.alamat');
        $this->db->select('pelanggan.is_aktive');
        $this->db->order_by('pelanggan.is_aktive', 'ASC');
        $this->db->order_by('pelanggan.id_cabang', $this->order);
        $this->db->order_by('pelanggan.id_pelanggan', $this->order);
        $this->db->like('id_pelanggan', $q);
        $this->db->or_like('nama_pelanggan', $q);
        $this->db->or_like('pelanggan.alamat', $q);
        $this->db->or_like('cabang', $q);
        $this->db->or_like('nama_paket', $q);
        $this->db->from('pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }
    // get data with limit and search
    function get_limit_riwayat($id)
    {
        $this->db->order_by('tahun', 'DESC');
        $this->db->order_by('bulan', 'DESC');
        $this->db->from('tagihan');
        $this->db->join('cara_bayar', 'cara_bayar.id_cara_bayar = tagihan.id_cara_bayar');
        $this->db->join('bulan', 'bulan.id_bulan = tagihan.bulan');
        $this->db->where('id_pelanggan', $id);
        $this->db->where('status_bayar', 'Y');
        $this->db->limit(12);
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
        $this->db->select('*', 'pelanggan.alamat', 'pelanggan.is_aktive AS aaktif');
        $this->db->where('id_pelanggan', $id);
        return $this->db->get()->row_array();
    }
    public function tampil_pelanggan()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->where('pelanggan.is_aktive', '1');
        return $this->db->get()->result_array();
    }
}

/* End of file User_level_model.php */
/* Location: ./application/models/User_level_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-20 18:40:20 */
/* http://harviacode.com */