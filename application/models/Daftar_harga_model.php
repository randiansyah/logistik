<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Daftar_harga_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
    }
      
	public function insert($data){
		$this->db->insert('daftar_harga', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('daftar_harga', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('daftar_harga'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
    }

    public function getKode($like){
        $this->db->select('idcbg')->from("daftar_harga"); 
        $this->db->like($like);  //cek dulu apakah ada sudah ada kode di tabel.    
        $query = $this->db->get();  //cek dulu apakah ada sudah ada kode di tabel.    
     
        if($query->num_rows() > 0){      
         
               //cek kode jika telah tersedia    
            $data = $query->row();      
            $kode = intval($query->num_rows()) + 1; 
        }else{      
             
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $batas = str_pad($kode, 3, "0", STR_PAD_LEFT);    
        $kodetampil = $batas;  //format kode
        return $kodetampil;
    }
    
	public function getAllById($where = array()){
        $this->db->select("daftar_harga.*")->from("daftar_harga");  
		$this->db->where($where); 
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}

	

     function getOneBy($where = array()){
        $this->db->select("*");
        $this->db->from('daftar_harga');
        $this->db->where($where); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }



	function getAllBy($limit,$start,$search,$col,$dir,$where)
    {
        $this->db->select("daftar_harga.*")->from("daftar_harga"); 
       	$this->db->limit($limit,$start)->order_by($col,$dir) ;
        if(!empty($where)){
                $this->db->where($where);   
            
        } 
    	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->like($key,$value);	
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
    	$this->db->select("daftar_harga.*")->from("daftar_harga");  
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->or_like($key,$value);	
			} 	
        } 
        
        $result = $this->db->get();
    
        return $result->num_rows();
	} 
}
