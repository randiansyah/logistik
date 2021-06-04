<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Transaksi_detail_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
    }
      
	public function insert($data){
		$this->db->insert('transaksi_detail', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('transaksi_detail', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('transaksi_detail'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
    }

    public function getKode($like){
        $this->db->select('id_transaksi_detail')->from("transaksi_detail"); 
        $this->db->like($like);  //cek dulu apakah ada sudah ada kode di tabel.    
        $query = $this->db->get();  //cek dulu apakah ada sudah ada kode di tabel.    
     
        if($query->num_rows() > 0){      
         
               //cek kode jika telah tersedia    
            $data = $query->row();      
            $kode = intval($query->num_rows()) + 1; 
        }else{      
             
            $kode = 1;  //cek jika kode belum terdapat pada table
        }
        $batas = str_pad($kode, 5, "0", STR_PAD_LEFT);    
        $kodetampil = $batas;  //format kode
        return $kodetampil;
    }
    
	public function getAllById($where = array()){
        $this->db->select("transaksi_detail.*")->from("transaksi_detail");  
		$this->db->where($where); 
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}

    public function getOneById($where = array()){
        $this->db->select("transaksi_detail.*")->from("transaksi_detail");  
        $this->db->where($where); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    }

    public function getAllByBarang($where = array()){
        $this->db->select("*")->from("transaksi_detail");
        $this->db->join("barang","transaksi_detail.barang_id = barang.id_barang","LEFT");  
        $this->db->where($where); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

	function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("transaksi_detail.*")->from("transaksi_detail"); 
       	$this->db->limit($limit,$start)->order_by($col,$dir) ;
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
    	$this->db->select("transaksi_detail.*")->from("transaksi_detail");  
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->like($key,$value);	
			} 	
        } 
        
        $result = $this->db->get();
    
        return $result->num_rows();
    } 
}
