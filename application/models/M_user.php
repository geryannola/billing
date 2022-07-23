<?php


class M_user extends CI_Model
{
	public function __construct(){
		parent::__construct();
		$this->load->database();
	}
	public function get($username){
        $this->db->where('username', $username); 
        $result = $this->db->get('users')->row();
        return $result;
    }

     public function user_token($user_token){
		$this->db->insert('user_token',$user_token);
	}

	public function get_by_id($id_username = null)
    {
        $this->db->from('users');
        if ($id_username !=null){
            $this->db->where('id_username', $id_username);
        }
        $query = $this->db->get();
        return $query;
    }
    public function ubah_data($data,$id_username){
        $this->db->where('id_username',$id_username);
        $this->db->update ('users',$data);
    }

}