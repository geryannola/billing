<?php

class M_login extends CI_Model
{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
 	public function checklogin($username, $password)
 	{
 		$this->db->from('users');
 		$this->db->where('username',$username);
 		$this->db->where('password',md5($password));
 		return $this->db->get()->num_rows();	
 	}
 	   public function tambahdata($data){
        $this->db->insert('users',$data);
    }
}