<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class User_roles_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
    }
      
	public function insert($data){
		$this->db->insert('users_roles', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('users_roles', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('users_roles'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
    }
    
	
}
