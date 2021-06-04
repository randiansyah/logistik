<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Menu_model extends CI_Model
{
	 

	public function __construct()
	{
		parent::__construct(); 
	}    
	public function getMenuSuperadmin($where = array()){
		$this->db->select("*");
		$this->db->from('menu');
		$this->db->where($where); 
		$this->db->order_by("menu.sequence");
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}

    public function getMenuOneBy($where = array()){
		$this->db->select("*");
		$this->db->from('menu');
		$this->db->where($where); 
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->row()->id; 
    	} 
    	return FALSE;
	}

	public function getMenuPrivilleges($where = array()){
		$this->db->select("menu.*");
		$this->db->from('privilleges');
		$this->db->join("menu","menu.id=privilleges.menu_id");
			$this->db->order_by("menu.sequence");
		$this->db->where($where); 
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}

	public function getParentIdBy($where = array()){
		$this->db->select("parent_id,name");
		$this->db->from('menu');
		$this->db->where($where); 
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->row(); 
    	} 
    	return FALSE;
	}
	public function getDetailMenuBy($where = array()){
		$this->db->select("*");
		$this->db->from('menu');
		$this->db->where($where); 
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->row(); 
    	} 
    	return FALSE;
	}

	public function getDataParentByMenus($whereString){
	 	 $query = $this->db->query("select id from menu where menu.id IN(
					select parent_id from menu where menu.id IN(".$whereString.")
					)"); 
	 	return $query->result(); 
    	  
	}

	public function getAllById($where = array()){
		$this->db->select("*");
		$this->db->from('menu');
		$this->db->where($where); 
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('menu', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('menu', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('menu'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit,$start,$search,$col,$dir)
    {
    	$this->db->select("menu.*, module.name as module_name")->from("menu"); 
    	$this->db->join("module","module.id=menu.module_id");
       	$this->db->limit($limit,$start)->order_by($col,$dir) ;
    	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);	
			} 	
    	} 
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

    	$this->db->select("*")->from("menu"); 
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);	
			} 	
    	}
		 
        $result = $this->db->get();
    
        return $result->num_rows();
    } 
}
