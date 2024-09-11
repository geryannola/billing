<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Qr extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->load->library('qr_code'); // Muat library QR Code
    $this->load->model('Xendit_model');
    $this->load->model('Tagihan_model');
    // $this->load->model('M_user');
  }

  public function index()
  {
    $id = $_GET['kode'];
    $data = array(
						'id' => $id,
						'url' => 'https://api.xendit.co',
						'link' => "/qr_codes",
					);
    $result = $this->Xendit_model->GetListofQRPaymentsbyQRID($data);
    $result = json_decode($result, true);
        var_dump($result);
    if (empty($result)) {
         $data = array(
             'id' => $id,
             'url' => 'https://api.xendit.co',
             'link' => "/qr_codes",
           );
         $result = $this->Xendit_model->GetQRCodebyQRID($data);
         $result = json_decode($result, true);
         // die();
         if ($result['status'] === 'ACTIVE') {
           // Path di mana QR code akan disimpan
           $fileName = $id . '.png'; // Nama file QR code
          //  var_dump(FCPATH . 'assets/assets/qrcodes/' . $fileName);
             $filePath = FCPATH . 'assets/assets/qrcodes/' . $fileName;
     
             // Tentukan ukuran QR Code dan margin
             $size = 8; // Ukuran QR Code, contoh: 6
             $margin = 2; // Margin, contoh: 2
             
             // Generate QR code
             $result = $this->qr_code->generate($id, $filePath, $size, $margin);
             if ($result) {
                $row = $this->Tagihan_model->get_by_qrXendit($id);
var_dump($row);
// die();
                $data['qr_code_url'] = base_url('assets/assets/qrcodes/' . $fileName);
                $data['jml_tagihan'] = $row->jml_tagihan;
                $this->load->view('qr_view', $data);
               } else {
                 echo 'Failed to generate QR Code.';
               }
             } else {
             $this->load->view('login');
             // $notif = 'Not Sent';
           }

       } else {

       }
  }
}