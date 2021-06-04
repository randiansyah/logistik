<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Dashboard extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
	 $this->load->model('transaksi_model'); 
	 $this->load->model('tracking_model');	
	 $this->load->model('customer_model'); 
	 $this->load->model('daftar_harga_model');
     $this->load->model('daftar_harga_key_model');
		 
	}
	public function index()
	{
		$this->load->helper('url');	

		 $this->data['pelanggan'] = $this->customer_model->getAllById();

		$this->data['permintaan_pesanan'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'order', 'status' => '1')); 

		//sales
		$this->data['pesanan'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'order', 'created_by' => $this->data['users']->id)); 

		$this->data['konfirmasi_pesanan'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'delivery','status' => 3, 'created_by' => $this->data['users']->id)); 

		 //$send = array ();
         //$send = "status IN ('3','4')";   
	    $this->data['belum_dipickup'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'pickup', 'status' => '2')); 

		$this->data['sedang_pickup'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'pickup', 'status' => '3')); 

		$this->data['werehouse'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'pickup', 'status' => '4')); 

		$this->data['selesai_pickup'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'pickup', 'status' => '5')); 

		//delivery
		$this->data['barang_masuk'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'delivery', 'status' => '1')); 

		$this->data['belum_delivery'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'delivery', 'status' => '2')); 

		$this->data['sedang_delivery'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'delivery', 'status' => '3')); 

		$this->data['selesai_delivery'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'delivery', 'status' => '4')); 

		$this->data['transaksi'] = $this->transaksi_model->getCountAllByID(array($where ='tipe' => 'transaksi'));



        
        $this->data['content'] = 'admin/dashboard';        
		$this->load->view('admin/layouts/page',$this->data); 
	} 

  

 public function daftarHarga()
  {
    $columns = array( 
            0 => 'id', 
            1 => 'id_transaksi',
            2 => 'nama',
            3 => 'telp',
            4 => 'kirim_via',
            5 => 'asal',
            6 => 'tujuan',
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $limit = 0;
      $start = 0;
      
  $where = array ();
  $send = "";    
      $totalData = $this->daftar_harga_model->getCountAllBy($limit,$start,$search,$order,$dir,$where);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        

      if($isSearchColumn){
        $totalFiltered = $this->daftar_harga_model->getCountAllBy($limit,$start,$search,$order,$dir,$where); 
      }else{
        $totalFiltered = $totalData;
      }  

       if(!empty($searchColumn[1]['search']['value'])){
        if(!empty($this->input->post('tujuan_darat'))){
           // $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['kirim_via']= "Darat";
            $search['tujuan'] = $this->input->post('tujuan_darat');
            
        }else{
        	  $where['kirim_via']= "kosong";
        }
            
       
        }

        if(!empty($searchColumn[2]['search']['value'])){
        if(!empty($this->input->post('tujuan_laut'))){
           // $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['kirim_via']= "Laut";
            $search['tujuan'] = $this->input->post('tujuan_laut');
            
        }else{
        	  $where['kirim_via']= "kosong";
        }
            
       
        }

          if(!empty($searchColumn[3]['search']['value'])){
        if(!empty($this->input->post('tujuan_udara'))){
           // $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['kirim_via']= "Udara";
            $search['tujuan'] = $this->input->post('tujuan_udara');
            
        }else{
        	  $where['kirim_via']= "kosong";
        }
            
       
        }

      /*
          if(!empty($this->input->post('tujuan_laut'))){
           // $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['kirim_via']= "Laut";
            $search['tujuan'] = $this->input->post('tujuan_laut');
            
        }else{
        	$where['kirim_via']= "kosong";
        }
          if(!empty($this->input->post('tujuan_udara'))){
           // $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $where['kirim_via']= "Udara";
            $search['tujuan'] = $this->input->post('tujuan_udara');
            
        }else{
        	$where['kirim_via']= "kosong";
        }

        if(!empty($searchColumn[1]['search']['value'])){
            $value = $searchColumn[2]['search']['value'];
            $isSearchColumn = true;
            $search['tujuan'] = $value;
            $where['kirim_via']= "Laut";
        }

        if(!empty($searchColumn[3]['search']['value'])){
            $value = $searchColumn[3]['search']['value'];
            $isSearchColumn = true;
            $search['tujuan'] = $value;
            $where['kirim_via']= "Udara";
        }
*/
       
    $limit = $this->input->post('length');
    $start = $this->input->post('start');
        $param      	= $this->input->post();
		$tujuan	= @$param['tujuan'];
			
  

    $datas = $this->daftar_harga_model->getAllBy($limit,$start,$search,$order,$dir,$where);
    $suburl = $this->uri->segment(1);
     
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   

             
          
           //  $nestedData['id']   = $start+$key+1;
            $nestedData['kg'] = $data->kg;
            $nestedData['min'] = $data->min;
            $nestedData['coli_a'] = number_format($data->coli_a,0);
            $nestedData['coli_b'] = number_format($data->coli_b,0);
            $nestedData['coli_c'] = number_format($data->coli_c,0);
            $nestedData['lead_time'] = $data->lead_time;
            $nestedData['keterangan'] = $data->keterangan;
            $nestedData['tujuan'] = $data->tujuan;
            
         
            $new_data[] = $nestedData; 
        }
    }
      
    $json_data = array(
                "draw"            => intval($this->input->post('draw')),  
                "recordsTotal"    => intval($totalData),  
                "recordsFiltered" => intval($totalFiltered), 
                "data"            => $new_data   
                );
        
    echo json_encode($json_data); 
  }

  public function totalhargaCS(){
	    $param      	= $this->input->post();
		$periode_start	= @$param['periode_start'];
		$periode_end	= @$param['periode_end'];
		$pelanggan      = @$param['pelanggan'];
		$today			= date('Y-m-d');
		$tgl_today		= mktime(0, 0, 0, date("m"), date("d")-6, date("Y"));
		$tujuh_hari		= date("Y-m-d", $tgl_today);

		if($pelanggan == ''){

			if($periode_start == ''){
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at,nama FROM transaksi WHERE tipe='delivery' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$tujuh_hari."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$today."' GROUP BY kode_pelanggan ORDER BY total DESC ");
			}else{
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at,nama FROM transaksi WHERE tipe='delivery' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$periode_start."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$periode_end."' GROUP BY kode_pelanggan ORDER BY total DESC");
			}

		}else{

			if($periode_start == ''){
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at,nama FROM transaksi WHERE tipe='delivery'  AND kode_pelanggan = '".$pelanggan."' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$tujuh_hari."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$today."' GROUP BY kode_pelanggan ORDER BY total DESC");
			}else{
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at,nama FROM transaksi WHERE tipe='delivery'  AND kode_pelanggan = '".$pelanggan."' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$periode_start."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$periode_end."'GROUP BY kode_pelanggan ORDER BY total DESC ");
			}

		}

     $new_data = array();
     $data = array();
     $data = $query->result();
       
     	foreach($query->result() as $key => $data){
            	$nestedData['total']= number_format($data->total,0,'.','.');
            	$nestedData['nama']= $data->nama;
                $nestedData['tanggal']= $data->created_at;
                $new_data[] = $nestedData;  				
        

		}
    $json_data = array(
                "data"            => $new_data   
                );
        
    echo json_encode($json_data); 
  }


  public function totalharga(){
	    $param      	= $this->input->post();
		$periode_start	= @$param['periode_start'];
		$periode_end	= @$param['periode_end'];
		$pelanggan      = @$param['pelanggan'];
		$today			= date('Y-m-d');
		$tgl_today		= mktime(0, 0, 0, date("m"), date("d")-6, date("Y"));
		$tujuh_hari		= date("Y-m-d", $tgl_today);

		if($pelanggan == ''){

			if($periode_start == ''){
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at FROM transaksi WHERE tipe='delivery' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$tujuh_hari."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$today."' ");
			}else{
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at FROM transaksi WHERE tipe='delivery' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$periode_start."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$periode_end."'");
			}

		}else{

			if($periode_start == ''){
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at FROM transaksi WHERE tipe='delivery'  AND kode_pelanggan = '".$pelanggan."' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$tujuh_hari."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$today."'");
			}else{
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at FROM transaksi WHERE tipe='delivery'  AND kode_pelanggan = '".$pelanggan."' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$periode_start."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$periode_end."' ");
			}

		}

     $response_data = array();
     $data = array();
     $data = $query->result();
     $response_data['data'] = $data;
      echo json_encode($response_data);
  }


	public function total_minggu_ini()
	{  
		$param      	= $this->input->post();
		$periode_start	= @$param['periode_start'];
		$periode_end	= @$param['periode_end'];
		$pelanggan      = @$param['pelanggan'];
		$today			= date('Y-m-d');
		$tgl_today		= mktime(0, 0, 0, date("m"), date("d")-6, date("Y"));
		$tujuh_hari		= date("Y-m-d", $tgl_today);

		if($pelanggan == ''){

			if($periode_start == ''){
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at FROM transaksi WHERE tipe='delivery' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$tujuh_hari."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$today."' GROUP BY DATE(created_at)   ORDER BY created_at ASC");
			}else{
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at FROM transaksi WHERE tipe='delivery' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$periode_start."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$periode_end."' GROUP BY DATE(created_at)  ORDER BY created_at ASC");
			}

		}else{

			if($periode_start == ''){
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at FROM transaksi WHERE tipe='delivery'  AND kode_pelanggan = '".$pelanggan."' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$tujuh_hari."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$today."' GROUP BY DATE(created_at)   ORDER BY created_at ASC");
			}else{
				$query = $this->db->query("SELECT SUM(total_harga_global) AS total,created_at FROM transaksi WHERE tipe='delivery'  AND kode_pelanggan = '".$pelanggan."' AND DATE_FORMAT(created_at,'%Y-%m-%d') >= '".$periode_start."' AND DATE_FORMAT(created_at,'%Y-%m-%d') <= '".$periode_end."' GROUP BY DATE(created_at)  ORDER BY created_at ASC");
			}

		}

			
		
	
	//	 echo $user;die;
	//	echo $this->db->last_query();die;
		@$total = [];
		@$created_at = [];
		@$totalharga = [];
		foreach($query->result_array() as $row){
            	@$total[]= (float)(@$row['total']);
				@$created_at[]= date('Y-m-d', strtotime(@$row['created_at']));
        

		}

		 
    
		// data json untuk chart
		$data= array(
			'tanggal' => $created_at,
			'total'  => $total,
		);
		
		echo json_encode($data);
	} 

	public function getINV(){
        $response_data = array();

        $inv = $this->input->get('inv');
        $data = array();
      $data = $this->tracking_model->getAllById(array("id_transaksi"=>$inv));
    
        $response_data['data'] = $data;


        echo json_encode($response_data);
	}

	public function getHarga(){
        $response_data = array();

        $inv = $this->input->get('inv');
        $data = array();
      $data = $this->tracking_model->getAllById(array("id_transaksi"=>$inv));
    
        $response_data['data'] = $data;


        echo json_encode($response_data);
	}


}
