<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Function_model extends CI_Model
{
     

    public function __construct()
    {
        parent::__construct(); 
    }  
     
    public function insert($data){ 
        $this->db->insert('function', $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update('function', $data, $where);
        return $this->db->affected_rows();
    }

    public function delete($where){
        $this->db->where($where);
        $this->db->delete('function'); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("*")->from("function"); 
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

    function getAllMenuFunction()
    {
        $this->db->select("menu.id,menu.name,function.name as function_name,function.id as function_id")->from("menu_function");
        $this->db->join("menu","menu.id = menu_function.menu_id"); 
        $this->db->join("function","function.id = menu_function.function_id"); 
        $this->db->where("parent_id !=",0);
        $this->db->where("url !=","#");
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
}
