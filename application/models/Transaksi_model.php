<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class Transaksi_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct(); 
    }
      
	public function insert($data){
		$this->db->insert('transaksi', $data);
		return $this->db->insert_id();
	}

	public function update($data,$where){
		$this->db->update('transaksi', $data, $where);
		return $this->db->affected_rows();
	}

	public function delete($where){
		$this->db->where($where);
		$this->db->delete('transaksi'); 
		if($this->db->affected_rows()){
			return TRUE;
		}
		return FALSE;
    }

     public function getKodePICKUP(){
        $this->db->select('id_transaksi')->from("transaksi"); 
       // $this->db->where($where);
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

     
     public function getKode($where = array()){
        $this->db->select('id_transaksi')->from("transaksi"); 
        $this->db->like($where);
        
        $query = $this->db->get();  //cek dulu apakah ada sudah ada kode di tabel.    
       $this->db->limit(1);    
        if($query->num_rows() <> 0){      
         
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

     public function getKodeInv($where = array()){
        $this->db->select('id_transaksi')->from("transaksi"); 
        $this->db->where($where);
        $query = $this->db->get();  //cek dulu apakah ada sudah ada kode di tabel.    
     
        if($query->num_rows() <> 0){      
         
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
        $this->db->select("transaksi.*")->from("transaksi");  
		$this->db->where($where); 
		$query = $this->db->get();
		if ($query->num_rows() >0){  
    		return $query->result(); 
    	} 
    	return FALSE;
	}

    public function getAllByJOIN($where = array()){
        $this->db->select("transaksi.*")->from("transaksi");  
          $this->db->join('transaksi_ukuran','transaksi.id_transaksi=transaksi_ukuran.id_transaksi','left');
        $this->db->where($where); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getMAXId($where){
        $this->db->select_max("id_transaksi")->from("transaksi");  
        $this->db->where($where); 
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


    public function getAllByIdOr($where = array(),$send = array()){
        $this->db->select("transaksi.*")->from("transaksi");  
        $this->db->where($where); 
        $this->db->where($send); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

function getAllBy($limit,$start,$search,$col,$dir,$where)
    {
        $this->db->select("transaksi.*,DATEDIFF(DATE_ADD(tgl_jatuh_tempo, INTERVAL -0 DAY), CURDATE()) as selisih")->from("transaksi");     
          if(!empty($search)){
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
        }     
          if(!empty($where)){
           $this->db->where($where);
        }

        $this->db->limit($limit,$start)->order_by($col,$dir) ;
      
        
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


    function getAllByCurdate($limit,$start,$search,$col,$dir,$where)
    {
        $this->db->select("transaksi.*")->from("transaksi");         
          if(!empty($where)){
           $this->db->where($where);
        }
        $this->db->where('date_format(tgl_jatuh_tempo,"%Y-%m-%d")', 'CURDATE()', FALSE);

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


   function getAllByOR($limit,$start,$search,$col,$dir,$where,$send)
    {
        $this->db->select("transaksi.*")->from("transaksi");         
          if(!empty($where)){
           $this->db->where($where);
        }
         if(!empty($send)){
           $this->db->where($send);
        }

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



  

     function getCountAllBy($limit,$start,$search,$order,$dir,$where)
    {
        $this->db->select("transaksi.*")->from("transaksi"); 
         if(!empty($where)){
           $this->db->where($where);
        }
         
        if(!empty($search)){
            foreach($search as $key => $value){
                $this->db->like($key,$value);   
            }   
        } 
        
        $result = $this->db->get();
    
        return $result->num_rows();
    } 

     function getCountAllByID($where)
    {
        $this->db->select("transaksi.*")->from("transaksi");  
        if(!empty($where)){
           $this->db->where($where);
        } 
        $result = $this->db->get();
    
        return $result->num_rows();
    }
      function getCountAllBySUM($limit,$start,$search,$order,$dir,$where)
    {
        $this->db->select("transaksi.*")->from("transaksi"); 
           $mutlak ="tipe='transaksi'";
        $this->db->where($mutlak);
        $this->db->where("(status='2' OR status='3')", NULL, FALSE);
         if(!empty($where)){
           $this->db->where($where);
        }
         
        if(!empty($search)){
            foreach($search as $key => $value){
                $this->db->like($key,$value);   
            }   
        } 
          $this->db->group_by('kode_pelanggan');
        $this->db->order_by('kode_pelanggan');
        
        $result = $this->db->get();
    
        return $result->num_rows();
    } 

function getAllBySUM($limit,$start,$search,$col,$dir,$where)
    {
        $this->db->select("transaksi.*,SUM(total_harga_global) as grand_total,nama,kode_pelanggan")->from("transaksi");    
          if(!empty($search)){
            foreach($search as $key => $value){
                $this->db->or_like($key,$value);    
            }   
        }     
        $mutlak ="tipe='transaksi'";
        $this->db->where($mutlak);
        $this->db->where("(status='2' OR status='3')", NULL, FALSE);
          if(!empty($where)){
            
           $this->db->where($where);
        }
        $this->db->group_by('kode_pelanggan');
        $this->db->order_by('kode_pelanggan');
        $this->db->limit($limit,$start)->order_by($col,$dir) ;
      
        
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

//kredit
public function getSumKredit($where){
$this->db->select("transaksi.*,SUM(total_harga_global) as grand_total,kode_pelanggan")->from("transaksi");  
  $mutlak ="tipe='transaksi' AND jenis_pembayaran='Kredit'";
        $this->db->where($mutlak);
 $this->db->where("(status='2' OR status='3')", NULL, FALSE);
          if(!empty($where)){
            
           $this->db->where($where);
        }
        $this->db->group_by('kode_pelanggan');
        $this->db->order_by('kode_pelanggan');
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    //cash
    public function getSumCash($where){
$this->db->select("transaksi.*,SUM(total_harga_global) as grand_total,kode_pelanggan")->from("transaksi");  
  $mutlak ="tipe='transaksi' AND jenis_pembayaran='Cash'";
        $this->db->where($mutlak);
        $this->db->where("(status='2' OR status='3')", NULL, FALSE);
          if(!empty($where)){
            
           $this->db->where($where);
        }
        $this->db->group_by('kode_pelanggan');
        $this->db->order_by('kode_pelanggan');
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

        public function getSumJatuhTempo($where){
$this->db->select("transaksi.*,SUM(total_harga_global) as grand_total,kode_pelanggan")->from("transaksi");  

 $mutlak ="tipe='transaksi' and status = '2' and tgl_jatuh_tempo <= CURDATE() ";
    $this->db->where($mutlak);
          if(!empty($where)){
            
           $this->db->where($where);
        }
        $this->db->group_by('kode_pelanggan');
        $this->db->order_by('kode_pelanggan');
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
//bayar
      public function getSumbelumBayar($where){
$this->db->select("transaksi.*,SUM(total_harga_global) as grand_total,kode_pelanggan")->from("transaksi");  
  $mutlak ="tipe='transaksi'";
    $this->db->where($mutlak);
    $this->db->where("(status='2' OR status='3')", NULL, FALSE);
          if(!empty($where)){
            
           $this->db->where($where);
        }
        $this->db->group_by('kode_pelanggan');
        $this->db->order_by('kode_pelanggan');
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }
     public function getSumBayar($where){
$this->db->select("transaksi.*,SUM(total_harga_global) as grand_total,kode_pelanggan")->from("transaksi");  
$mutlak ="tipe='transaksi'";
    $this->db->where($mutlak);
        $this->db->where("(status='3')", NULL, FALSE);
          if(!empty($where)){
            
           $this->db->where($where);
        }
        $this->db->group_by('kode_pelanggan');
        $this->db->order_by('kode_pelanggan');
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    public function getSumKreditBayar($where){
$this->db->select("transaksi.*,SUM(total_harga_global) as grand_total,kode_pelanggan")->from("transaksi");  
 $mutlak ="tipe='transaksi' AND jenis_pembayaran='Kredit'";
    $this->db->where($mutlak);
        $this->db->where("(status='3')", NULL, FALSE);
          if(!empty($where)){
            
           $this->db->where($where);
        }
        $this->db->group_by('kode_pelanggan');
        $this->db->order_by('kode_pelanggan');
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

    //cash
    public function getSumCashBayar($where){
$this->db->select("transaksi.*,SUM(total_harga_global) as grand_total,kode_pelanggan")->from("transaksi");  
$mutlak ="tipe='transaksi' AND jenis_pembayaran='Cash' ";
    $this->db->where($mutlak);
        $this->db->where("(status='3')", NULL, FALSE);
          if(!empty($where)){
            
           $this->db->where($where);
        }
        $this->db->group_by('kode_pelanggan');
        $this->db->order_by('kode_pelanggan');
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    }

  

}
