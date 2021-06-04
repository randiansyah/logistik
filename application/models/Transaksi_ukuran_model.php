<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Transaksi_ukuran_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
    }
      
	public function insert($data){
		$this->db->insert('transaksi_ukuran', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('transaksi_ukuran', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('transaksi_ukuran'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
    }

  
    
	public function getAllById($where = array()){
        $this->db->select("transaksi_ukuran.*")->from("transaksi_ukuran");  
		$this->db->where($where); 
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}
    public function getAllByIdOr($where = array(),$send = array()){
        $this->db->select("transaksi_ukuran.*")->from("transaksi_ukuran");  
        $this->db->where($where); 
        $this->db->where($send); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

	function getAllBy($limit,$start,$search,$col,$dir,$where,$send)
    {
        // echo $send;die;
        $this->db->select("transaksi_ukuran.*")->from("transaksi_ukuran"); 
      
        if(!empty($where)){
           $this->db->where($where);
        }
         
          
        $this->db->limit($limit,$start)->order_by($col,$dir) ;
        
    	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->like($key,$value);	
			} 	
        } 
        if(!empty($send)){
           // $tes=array('retur');
           $this->db->or_where($send);
            if(!empty($search)){
            foreach($search as $key => $value){
                $this->db->like($key,$value);   
            }   
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
   public function getSumAllbyid($where = array()){
$this->db->select("transaksi_ukuran.*,SUM(jumlah) as qty,SUM(harga_satuan) as satuan,SUM(total_harga_packing) as packing,SUM(total_harga_asuransi) as asuransi,SUM(total_harga_satuan) as total_satuan")->from("transaksi_ukuran");  
        $this->db->where($where); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
  

}
