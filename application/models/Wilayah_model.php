<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
class wilayah_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct(); 
    }
    public function getAllById($where = array()){
        $this->db->select("*");
        $this->db->from('wilayah');
        $this->db->where($where); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 
    public function getAllByWhereIn($where_prop = array(),$where_kab = array(),$where_kec = array(),$where_desa = array()){
        $this->db->select("*");
        $this->db->from('wilayah'); 
        if(!empty($where_prop)){ 
            $this->db->where_in('wilayah.KDPROP',$where_prop); 
        }
        if(!empty($where_kab)){

            $this->db->where_in('wilayah.KDKAB',$where_kab); 
        }
        if(!empty($where_kec)){

            $this->db->where_in('wilayah.KDKEC',$where_kec); 
        }
        if(!empty($where_desa)){ 
            $this->db->where_in('wilayah.KDDESA',$where_desa); 
        } 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 
    public function getAllProvince($where = array(),$where_in = array()){
        $this->db->select("kdprop,nmprop");
        $this->db->from('wilayah');
        $this->db->where($where); 
        if (@count($where_in)>0) {
            $this->db->where_in('kdprop',$where_in); 
        }
        $this->db->group_by("kdprop,nmprop"); 
        $this->db->order_by("nmprop"); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 

    public function getAllKecamatanWhereIn($where = array(),$where_in = array()){
        $this->db->select("MAX(kdprop + kdkab + kdkec) as kd_wil,kdkab,nmkab,kdkec,nmkec");
        $this->db->from('wilayah');
        $this->db->where($where);
        // if (@count($where_in)>0) {
        //     $this->db->where_in('kdkab',$where_in); 
        // }
        if(!empty($where_in)){
    		foreach($where_in as $key => $value){
				$this->db->where_in($key,$value);	
			} 	
		} 
        $this->db->group_by("kdkab,nmkab,kdkec,nmkec");
        $this->db->order_by("nmkab,nmkec");
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 

    public function getAllDesaWhereInUser($where = array(),$where_in_kab = array(),$where_in_kec = array()){
        $this->db->select("MAX(kdprop + kdkab + kdkec + kddesa) as kd_wil,kdkab,kdkec,nmkec,kddesa,nmdesa");
        $this->db->from('wilayah');
        $this->db->where($where);
        if (@count($where_in_kab)>0) {
            $this->db->where_in('kdkab',$where_in_kab); 
        }
        if (@count($where_in_kec)>0) {
            $this->db->where_in('(kdkab+kdkec)',$where_in_kec); 
        }
        $this->db->group_by("kdkab,kdkec,nmkec,kddesa,nmdesa");
        $this->db->order_by("nmkec,nmdesa");
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 

    public function getAllDesaWhereIn($where = array(),$where_in_kab = array(),$where_in_kec = array()){
        $this->db->select("MAX(kdprop + kdkab + kdkec + kddesa) as kd_wil,kdkab,kdkec,nmkec,kddesa,nmdesa");
        $this->db->from('wilayah');
        $this->db->where($where);
        if (@count($where_in_kab)>0) {
            $this->db->where_in('kdkab',$where_in_kab); 
        }
        if (@count($where_in_kec)>0) {
            $this->db->where_in('kdkec',$where_in_kec); 
        }
        $this->db->group_by("kdkab,kdkec,nmkec,kddesa,nmdesa");
        $this->db->order_by("nmkec,nmdesa");
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 

    public function getAllKabupaten($where = array()){
        $this->db->select("MAX(kdprop + kdkab) as kd_wil, kdkab,nmkab");
        $this->db->from('wilayah');
        $this->db->where($where); 
       // $this->db->group_by("kdkab,nmkab"); 
        //$this->db->order_by("nmkab"); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 
  public function getALLTES(){
      $this->db->select("kddesa,nmdesa");

        $this->db->from('wilayah');
    //   $this->db->where($where); 
      //  $this->db->group_by("kdkab,kdkec,nmkab,nmkec,kddesa,nmdesa");
       $this->db->order_by("kddesa,nmdesa");
        $this->db->limit(100);
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 




    public function getAllKecamatan($where = array()){
        $this->db->select("MAX(kdprop + kdkab + kdkec) as kd_wil,kdkab,nmkab, kdkec,nmkec");
        $this->db->from('wilayah');
        $this->db->where($where);
        $this->db->group_by("kdkab,nmkab,kdkec,nmkec");
        $this->db->order_by("nmkec");
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 
    public function getAllKelurahan($where = array(),$where_in = array()){
        $this->db->select("MAX(kdprop + kdkab + kdkec + kddesa) as kd_wil,kdkab,kdkec,nmkec,kddesa,nmdesa");
        $this->db->from('wilayah');
        $this->db->where($where);  
        if(!empty($where_in)){
            foreach($where_in as $key => $value){
                $this->db->where_in($key,$value);
            }    
        }
        $this->db->group_by("kdkab,kdkec,nmkec,kddesa,nmdesa");
        $this->db->order_by("nmkec,nmdesa");
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 
    public function getAllWhereInKelurahan($where = array(),$where_in = array()){
        $this->db->select("idwilayah,kddesa,nmdesa");
        $this->db->from('wilayah');
        $this->db->where($where);  
        if(@count($where_in) > 0){
            $this->db->where_in("kddesa",$where_in);
        }
        $this->db->group_by("idwilayah,kddesa,nmdesa"); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->result(); 
        } 
        return FALSE;
    } 

    public function getInBy($where=array()){
        $this->db->select("*")->from("wilayah"); 
        $this->db->where_in('idwilayah',$where); 
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

    public function getOneBy($where = array()){
        $this->db->select("*");
        $this->db->from('wilayah');
        $this->db->where($where); 
        $query = $this->db->get();
        if ($query->num_rows() >0){  
            return $query->row(); 
        } 
        return FALSE;
    } 
    public function insert($data){
        $this->db->insert('wilayah', $data);
        return $this->db->insert_id();
    }

    public function update($data,$where){
        $this->db->update('wilayah', $data, $where);
        return $this->db->affected_rows();
    }

    function getAllBy($limit,$start,$search,$col,$dir)
    {
        $this->db->select("wilayah.*")->from("wilayah"); 
 
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
    	$this->db->select("COUNT(1) as total");
        $this->db->from('wilayah');
	   	if(!empty($search)){
    		foreach($search as $key => $value){
				$this->db->like($key,$value);	
			} 	
    	}  
        $result = $this->db->get();
        $result = $result->row();
    
        return $result->total == '' ? 0 : $result->total;
    } 

    public function delete($where){
        $this->db->where($where);
        $this->db->delete('wilayah'); 
        if($this->db->affected_rows()){
            return TRUE;
        }
        return FALSE;
    }
    public function insert_batch($data){
        $this->db->insert_batch('wilayah', $data);
        return $this->db->insert_id();
    }
}
