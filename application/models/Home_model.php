<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_Model
{

    // public $table = 'kas_masuk';
    // public $id = 'id_km';
    // public $jenis = 'jenis';
    // public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // // get all
    // function get_all()
    // {
    //     $this->db->order_by($this->id, $this->order);
    //     $this->db->join('cara_bayar', 'cara_bayar.id_cara_bayar = kas_masuk.id_cara_bayar');
    //     $this->db->where($this->jenis, 'Keluar');
    //     return $this->db->get($this->table)->result();
    // }

    // // get data by id
    // function get_by_id($id)
    // {
    //     $this->db->where($this->id, $id);
    //     return $this->db->get($this->table)->row();
    // }

    // // get total rows
    // function total_rows($q = NULL)
    // {
    //     $this->db->like('cara_bayar', $q);
    //     $this->db->from($this->table);
    //     $this->db->join('cara_bayar', 'cara_bayar.id_cara_bayar = kas_masuk.id_cara_bayar');
    //     return $this->db->count_all_results();
    // }

    // // get data with limit and search
    // function get_limit_data($limit, $start = 0, $q = NULL)
    // {
    //     $this->db->order_by($this->id, $this->order);
    //     $this->db->or_like('cara_bayar', $q);
    //     $this->db->where('jenis', 'Keluar');
    //     $this->db->limit($limit, $start);
    //     $this->db->join('cara_bayar', 'cara_bayar.id_cara_bayar = kas_masuk.id_cara_bayar');
    //     return $this->db->get($this->table)->result();
    // }

    // // insert data
    // function insert($data)
    // {
    //     $this->db->insert($this->table, $data);
    // }

    // // update data
    // function update($id, $data)
    // {
    //     $this->db->where($this->id, $id);
    //     $this->db->update($this->table, $data);
    // }

    // // delete data
    // function delete($id)
    // {
    //     $this->db->where($this->id, $id);
    //     $this->db->delete($this->table);
    // }
    public function total()
    {
        $this->db->from('pelanggan');
        $this->db->where('is_aktive', '1');
        return $this->db->get()->num_rows();
    }

    public function total_abc()
    {
        $this->db->from('pelanggan');
        $this->db->where('id_cabang', '1');
        $this->db->where('is_aktive', '1');
        return $this->db->get()->num_rows();
    }

    public function total_kassi()
    {
        $this->db->from('pelanggan');
        $this->db->where('id_cabang', '2');
        $this->db->where('is_aktive', '1');
        return $this->db->get()->num_rows();
    }
    public function total_keluar_per($tgl1, $tgl2)
    {
        $this->db->select_sum('keluar');
        // $this->db->where($this->jenis, 'Keluar' and 'tgl_km BETWEEN' . $tgl1 . 'AND' . $tgl2);
        $this->db->where($this->jenis, 'Keluar');
        $this->db->where('tgl_km BETWEEN "' . $tgl1 . '" AND "' . $tgl2 . '"');
        return $this->db->get($this->table)->row();
    }
}

/* End of file Kas_masjid_model_keluar.php */
/* Location: ./application/models/Kas_masjid_model_keluar.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-22 18:09:46 */
/* http://harviacode.com */