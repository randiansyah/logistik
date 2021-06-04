<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Groups_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
	}  
	public function getAllById($where = array()){
        $this->db->select("groups.*")->from("groups");  
		// $this->db->select("groups.*,  area.name as area_name")->from("groups");  
    	// $this->db->join("area","area.id = groups.area_id");
		$this->db->where($where); 
    	// $this->db->where("area.is_deleted",0);
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}
	public function insert($data){
		$this->db->insert('groups', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('groups', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('groups'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
	}

	function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("groups.*")->from("groups");  
    	// $this->db->select("groups.*,  area.name  as area_name")->from("groups");  
    	// $this->db->join("area","area.id = groups.area_id");
    
       	$this->db->limit($limit,$start)->order_by($col,$dir) ;
    	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);	
			} 	
    	} 
        // $this->db->where("area.is_deleted",0);
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

    	$this->db->select("groups.*")->from("groups");  
        // $this->db->select("groups.*,  area.name  as area_name")->from("groups");  
    	// $this->db->join("area","area.id = groups.area_id");
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);	
			} 	
    	} 
    	// $this->db->where("area.is_deleted",0);
        $result = $this->db->get();
    
        return $result->num_rows();
    } 
}
