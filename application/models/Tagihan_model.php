<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tagihan_model extends CI_Model
{

    public $table = 'tagihan';
    public $id = 'id_tagihan';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        return $this->db->get($this->table)->result();
    }


    function get_by_id($id)
    {
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        $this->db->join('bulan', 'bulan.id_bulan = tagihan.bulan');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_by_notif()
    {
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        $this->db->join('bulan', 'bulan.id_bulan = tagihan.bulan');
        // $this->db->join('tahun', 'tahun.id_tahun = tagihan.tahun');
        $this->db->where('status_bayar', 'N');
        return $this->db->get($this->table)->result();
    }

    // get total rows
    function total_rows($q = NULL, $Y)
    {
        $this->db->like('nama_pelanggan', $q);
        $this->db->where('tagihan.status_bayar', 'N');
        $this->db->or_like('bulan.nama_bulan', $q);
        $this->db->from($this->table);
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->join('bulan', 'bulan.id_bulan = tagihan.bulan');
        $this->db->where('tagihan.status_bayar', 'N');
        $this->db->order_by('tagihan.id_pelanggan', $this->order);
        $this->db->order_by('tagihan.bulan', $this->order);
        $this->db->order_by('tagihan.tahun', $this->order);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $y)
    {
        // $this->db->order_by($this->id, $this->order);
        $this->db->like('bulan.nama_bulan', $q);
        $this->db->where('tagihan.status_bayar', 'N');
        $this->db->or_like('nama_pelanggan', $q);
        $this->db->from('tagihan');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan');
        $this->db->join('cabang', 'cabang.id_cabang = pelanggan.id_cabang');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        $this->db->join('bulan', 'bulan.id_bulan = tagihan.bulan');
        $this->db->where('tagihan.status_bayar', 'N');
        $this->db->limit($limit, $start);
        $this->db->order_by('tagihan.id_pelanggan', $this->order);
        $this->db->order_by('tagihan.bulan', $this->order);
        $this->db->order_by('tagihan.tahun', $this->order);
        return $this->db->get()->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // insert data
    function insert_all($data)
    {
        $this->db->insert_batch($this->table, $data);
    }

    // bayar data
    function bayar($id, $data)
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
        $this->db->from('tagihan');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan');
        $this->db->where('id_tagihan', $id);
        return $this->db->get()->row_array();
    }
    public function tampil_bulan()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('bulan');
        return $this->db->get()->result_array();
    }
    public function tampil_tahun()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('tahun');
        return $this->db->get()->result_array();
    }
    public function tampil_bayar()
    {
        $result = array();
        $this->db->select('*');
        $this->db->from('cara_bayar');
        return $this->db->get()->result_array();
    }

    //GET PRODUCT BY PACKAGE ID
    function get_pelanggan_by_cabang($id_cabang)
    {
        $this->db->select('*');
        $this->db->from('pelanggan');
        $this->db->where('id_cabang', $id_cabang);
        $query = $this->db->get();
        return $query;
    }

    // // CREATE
    // function create_package($package, $product)
    // {
    //     $this->db->trans_start();
    //     //INSERT TO PACKAGE
    //     date_default_timezone_set("Asia/Bangkok");
    //     $data  = array(
    //         'package_name' => $package,
    //         'package_created_at' => date('Y-m-d H:i:s')
    //     );
    //     $this->db->insert('package', $data);
    //     //GET ID PACKAGE
    //     $package_id = $this->db->insert_id();
    //     $result = array();
    //     foreach ($product as $key => $val) {
    //         $result[] = array(
    //             'detail_package_id'   => $package_id,
    //             'detail_product_id'   => $_POST['product'][$key]
    //         );
    //     }
    //     //MULTIPLE INSERT TO DETAIL TABLE
    //     $this->db->insert_batch('detail', $result);
    //     $this->db->trans_complete();
    // }
    public function total_tagihan()
    {
        $this->db->select_sum('jml_tagihan');
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        $this->db->where('tagihan.status_bayar', 'N');
        return $this->db->get($this->table)->row();
    }
    function get_by_qrXendit($id)
    {
        $this->db->join('pelanggan', 'pelanggan.id_pelanggan = tagihan.id_pelanggan');
        $this->db->join('paket', 'paket.id_paket = pelanggan.id_paket');
        $this->db->join('bulan', 'bulan.id_bulan = tagihan.bulan');
        $this->db->where('qr_xendit', $id);
        return $this->db->get($this->table)->row();
    }
}

                        
                        /* End of file Tagihan_model.php */
                        /* Location: ./application/models/kas_masuk_model.php */
                        /* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2020-05-22 17:57:40 */
/* http://harviacode.com */