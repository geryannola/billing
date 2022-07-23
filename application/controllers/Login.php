<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller { 
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_login');
	    $this->load->model('M_user');
	}

	public function index()
	{
    check_already_login();
		$this->load->view('login');
	}
	public function loginsubmit(){
	$username = $this->input->post('username');
  	$user= $this->M_user->get($username);

    $this->form_validation->set_rules('username', 'Username','required',array('required'=>'Silahkan Masukan Username Anda'));
    $this->form_validation->set_rules('password', 'Password','required',array('required'=>'Silahkan Masukan Password Anda')); 
    if($this->form_validation->run()==false){
    $this->load->view('login');

    }else{
      if($this->M_login->checklogin($_POST['username'], $_POST['password'])>0){
        $this->session->set_userdata('is_aktive', $user->is_aktive);
        if ($this->session->userdata('is_aktive') == 1){
        $this->session->set_userdata('username', $_POST['username']);
        $this->session->set_userdata('password', $_POST['password']);
        $this->session->set_userdata('nama', $user->nama);
        $this->session->set_userdata('level', $user->id_level);
        $this->session->set_userdata('id_username', $user->id_username);
        redirect('home');
      }else{
       echo "<script>
        alert('Silahkan hubungi admin untuk aktivasi akun');
        window.location='".site_url('Login')."'</script>";
          }
      }else{
        echo "<script>
				alert('Login Gagal, Username atau password salah');
				window.location='".site_url('Login')."'</script>";
      }
    }
  }

	public function logout(){
        $this->session->sess_destroy();
        redirect('login');
    }

  public function simpan_user(){
    $this->form_validation->set_rules('username', 'Username', 'trim|is_unique[users.username]');
    $this->form_validation->set_rules('email', 'Email', 'is_unique[users.email]');
    $data = array(
      'nama'          => $this->input->post('nama',true),
      'username'      => $this->input->post('username',true),
      'password'      => md5($this->input->post('password',true)),
      'email'         => $this->input->post('email',true),
      'create_date'   => date('y-m-d H:i:s'),
      'id_level'      => 2,
      'is_aktive'     => 2,
    );

    if ($this->form_validation->run() === FALSE){
      echo "<script>
        alert('Username/Email ini sudah terpakai, Silahkan ganti');
        window.location='".site_url('Login#signup')."'</script>";
    }else{
      $oke          =$this->M_login->tambahdata($data);
      echo "<script>
        alert('Username berhasil dibuat');
        window.location='".site_url('Login')."'</script>";
    }
  }

  public function lupa_password(){
    $this->form_validation->set_rules('email','Email', 'required');
    if($this->form_validation->run() == false){
      $this->load->view('login');
    }else{
      $email = $this->input->post('email');
      $user = $this->db->get_where('users',['email' =>$email,'is_aktive' =>1])->row_array();

      if ($user) {
        $token = base64_encode(random_bytes(32));
        $user_token =[
            'email' =>$this->input->post('email',true),
            'token' =>$token,
            'create_date' =>time()
          ];
          $oke         =$this->M_user->user_token($user_token);
          $this->_send_email($token,'forgot');
          echo "<script>
        alert('Silahkan cek email untuk reset password');
        window.location='".site_url('login')."'</script>";
      }else{
        echo "<script>
        alert('Email tidak terdaftar atau user belum aktive');
        window.location='".site_url('login')."'</script>";
      }
    }  
  }

    private function _send_email($token, $type){
    $config = [
      'protocol'   =>'smtp',
      'smtp_host'  =>'ssl://smtp.googlemail.com',
      'smtp_user'  =>'ramdansaeful327@gmail.com',
      'smtp_pass'  =>'ramdan9090',
      'smtp_port'  =>465,
      'mailtype'   =>'html',
      'charset'    =>'utf-8',
      'newline'    =>"\r\n"

    ];

    $this->load->library('email',$config);
    $this->email->from('ramdansaeful327@gmail.com','Admin WEB Aplication');
    $this->email->to($this->input->post('email'));

    if($type =='verify'){
      $this->email->subject('Aktivasi Akun');
      $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'login/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '&username='. $this->input->post('username') . '">Activate</a>');
    }else if ($type == 'forgot'){
      $this->email->subject('Reset Password');
      $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'login/reset_password?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');

    }
    
    if($this->email->send()){
      return true;
    }else{
      echo $this->email->print_debugger();
      die;
    }

  }

    public function reset_password(){
    $email = $this->input->get('email');
    $token = $this->input->get('token');
    $user = $this->db->get_where('users', ['email' =>$email])->row_array();
    if($user){
      $user_token = $this->db->get_where('user_token', ['token' =>$token])->row_array();
      if ($user_token){
        if (time() - $user_token['create_date'] < (60 * 60 * 24)){
          $this->session->set_userdata('reset_email', $email);
          $this->rubah_password();
        }else{
        $this->db->delete('user_token', ['email' => $email]);
        echo "<script>
        alert('Reset password gagal, Token Kadaluarsa');
        window.location='".site_url('Login')."'</script>";
        }
      }else{
        echo "<script>
        alert('Reset Password gagal, Token salah');
        window.location='".site_url('Login')."'</script>";
      }


    }else{
      echo "<script>
        alert('Reset Password gagal, Email salah');
        window.location='".site_url('Login')."'</script>";
    }


  }

  public function rubah_password(){ //reset password
  if(!$this->session->userdata('reset_email')){
    redirect('login');
  }
  $this->form_validation->set_rules('password','password', 'required');
  $this->form_validation->set_rules('passcon','passcon', 'required');
  if($this->form_validation->run() == false){
      $this->load->view('rubah_password/v_rubah_password');
  }else{
    $password = md5($this->input->post('password',true));
    $email    = $this->session->userdata('reset_email');
    $this->db->set('password',$password);
    $this->db->where('email', $email);
    $this->db->update('users');
    $this->db->delete('user_token',['email' =>$email]);
    $this->session->unset_userdata('reset_email');
    echo "<script>
        alert('Password berhasil di rubah, Silahkan Login');
        window.location='".site_url('Login')."'</script>";
  }
}
  public function ganti_password($id_username){
         $this->template->load('template', 'rubah_password/v_ganti_password');
    }

  public function submit_ganti_password($id_username){
    $passwordlama =$this->input->post('lama'); // poSt dari inputan password lama
    if ($this->session->userdata('level')!=1) {
      if ($this->session->userdata('password')==$passwordlama) { // cek kondisi jika password lama sama degn password yg di database
    $data = array(
      //yang kiri sesuai filed table sedangkan yang kanan sesuai dari form inputan//
      'password'      => md5($this->input->post('password',true)),
    );
    $this->M_user->ubah_data($data,$id_username); // variable content dan variable nama array harus sama 
    redirect('login/logout');
    }else{ //jika password lama beda dengan yang ada di database akan di arahkan langsung ke HOMe
      echo "<script>
        alert('Password Lama Salah');
        window.location='".site_url('home')."'</script>";
    } 
    }else{

    $data = array(
      'password'      => md5($this->input->post('password',true)), //yang kiri sesuai filed table sedangkan yang kanan sesuai dari form inputan//
    );
    $this->M_user->ubah_data($data,$id_username); // variable content dan variable nama array harus sama 
    redirect('login/logout');

    }
  }
  public function edit_profile($id_username){
         $oke['data_user'] = $this->M_user->get_by_id($id_username)->row_array();
         $this->template->load('template', 'rubah_password/v_edit_profile', $oke);
    }
  public function update_edit_profile($id_username) 
    {
        $data = array(
        'nama' => $this->input->post('nama',TRUE),
        'email' => $this->input->post('email',TRUE),
        'alamat' => $this->input->post('alamat',TRUE),
        'kota' => $this->input->post('kota',TRUE),
        'provinsi' => $this->input->post('provinsi',TRUE),
        'telepon' => $this->input->post('telepon',TRUE),
        );

        $oke          =$this->M_user->ubah_data($data,$id_username);
        redirect('home');
        
    }
    

}
