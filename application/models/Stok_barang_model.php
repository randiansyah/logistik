<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Stok_barang_model extends CI_Model
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

    public function update_batch($data,$where,$where_in){
        $this->db->where($where);
        $this->db->update_batch('transaksi_detail', $data, $where_in);
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

    public function getSumQty($where = array()){
        $this->db->select('barang_id, SUM(qty) AS total', FALSE);
        $this->db->where($where);
        $this->db->group_by("barang_id");
        $query = $this->db->get('transaksi_detail');
        if ($query->num_rows() >0){  
            $result = $query->row(); 
            return $result->total; 
        } 
        return 0;
    }

    public function getRekapLaporan($where = array()){
        $this->db->select('d_cabang,transaksi_detail.created_at,cabang.tipe_cbg');
        $this->db->join("cabang","cabang.kdcbg = transaksi_detail.d_cabang");        
        $this->db->where($where);
        $this->db->group_by("d_cabang,transaksi_detail.created_at,cabang.tipe_cbg");
        $this->db->order_by("transaksi_detail.created_at");
        $query = $this->db->get('transaksi_detail');
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getSumHarga($where = array()){
        $this->db->select('type, created_at, SUM(harga*qty) AS total');
        $this->db->where($where);
        $this->db->group_by("created_at, type");
        $this->db->order_by("created_at, type");
        $query = $this->db->get('transaksi_detail');
        if ($query->num_rows() >0){  
            $result = $query->row(); 
            return $result->total; 
        } 
        return 0;
    }

    public function getAllByBarang($where = array()){
        $this->db->select("*")->from("barang");
        $this->db->join("transaksi_detail","barang.id_barang = transaksi_detail.barang_id");
        $this->db->group_by("barang_id");
        $this->db->order_by("barang_id");
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

	function getAllBy($limit,$start,$search,$col,$dir,$where)
    {
        $this->db->select("*")->from("barang");
        $this->db->join("transaksi_detail","barang.id_barang = transaksi_detail.barang_id");
        $this->db->group_by("barang_id");
        $this->db->order_by("barang_id");
        $this->db->where($where);
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

    function getCountAllBy($limit,$start,$search,$order,$dir,$where)
    {
    	$this->db->select("*")->from("barang");
        $this->db->join("transaksi_detail","barang.id_barang = transaksi_detail.barang_id");
        $this->db->group_by("barang_id");
        $this->db->order_by("barang_id");
        $this->db->where($where);

	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->like($key,$value);	
			} 	
        } 
        
        $result = $this->db->get();
    
        return $result->num_rows();
    } 
}
