<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class User_model extends CI_Model
{
	 

	public function __construct()
	{
		parent::__construct(); 
	}  
	public function getAllById($where = array()){
		$this->db->select("users.*, roles.id as role_id, roles.name as role_name")->from("users"); 
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id"); 
		$this->db->where("users.is_deleted",0);
		$this->db->where("roles.is_deleted",0); 
		 
 		$roles_default = array('1');
        $this->db->where_not_in('roles.id', $roles_default);
		$this->db->where($where); 

		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('users', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('users', $data, $where);
		return $this->db->affected_rows();
	}
	
	public function delete($where){
		$this->db->where($where);
		$this->db->delete('users'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getOneBy($where = array()){
		$this->db->select("users.*, roles.id as role_id, roles.name as role_name")->from("users"); 
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id");   
  		
  		$roles_default = array('1','2');
        $this->db->where_not_in('roles.id', $roles_default);
		
		$this->db->where("users.is_deleted",0);
		$this->db->where("roles.is_deleted",0); 
		$this->db->where($where); 

		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->row(); 
    	} 
    	return FALSE;
	}

	function getOneUserBy($where = array()){
		$this->db->select("users.*, roles.id as role_id, roles.name as role_name")->from("users"); 
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id");   
        //$this->db->where('roles.id', 2);
		
		// $this->db->where("users.is_deleted",0);
		// $this->db->where("roles.is_deleted",0); 
		$this->db->where($where); 

		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->row(); 
    	} 
    	return FALSE;
	}

	function getAllBy($limit,$start,$search,$col,$dir)
    {
    	$this->db->select("users.*, roles.name as role_name")->from("users"); 
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id"); 
       	$this->db->limit($limit,$start)->order_by($col,$dir) ;
    	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->like($key,$value);	
			} 	
		} 
		$roles_default = array('1');
        $this->db->where_not_in('roles.id', $roles_default);
		$this->db->where("roles.is_deleted",0); 
       	$result = $this->db->get();
        if($result->num_rows()>0)
        {
            return $result->result();  
        }
        else
        {
            return null;
        }
    }

    function getCountAllBy($limit,$start,$search,$order,$dir)
    {

    	$this->db->select("users.*, roles.name as role_name")->from("users"); 
    	$this->db->join("users_roles","users.id = users_roles.user_id");
    	$this->db->join("roles","roles.id = users_roles.role_id"); 
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->like($key,$value);	
			} 	
    	} 
		$roles_default = array('1');
        $this->db->where_not_in('roles.id', $roles_default); 
		$this->db->where("roles.is_deleted",0); 
        $result = $this->db->get();
    
        return $result->num_rows();
    } 
}
