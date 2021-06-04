<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Menu extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
		$this->load->model('daftar_menu_model'); 
		$this->load->model('daftar_menu_detail_model'); 
		$this->load->model('cabang_model'); 
		$this->load->model('kategori_model');  
		$this->load->model('satuan_model');  
		$this->load->model('barang_model');  
	}
	public function index()
	{
		$this->load->helper('url');
		if($this->data['is_can_read']){
			$this->data['content'] = 'admin/menu/list_v'; 
			$this->data['kategori']  = $this->kategori_model->getAllById();	
			$this->data['cabang'] = $this->cabang_model->getAllByCabang(array('tipe_cbg' => 'M'));
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
		}
		
		$this->load->view('admin/layouts/page',$this->data);  
	}

	public function create()
	{ 
		$this->form_validation->set_rules('nama_menu',"Nama Harus diisi", 'trim|required');  
		if ($this->form_validation->run() === TRUE)
		{ 
			
			$data = array( 
				'id_cabang'     => $this->input->post('id_cabang'),
				'nama_menu'    	=> $this->input->post('nama_menu'),
				'label_menu'    => $this->input->post('label_menu'),
				'kelas_menu'   	=> $this->input->post('kelas_menu'),
				'kategori_menu' => $this->input->post('kategori_menu'),
				'tipe_menu'   	=> $this->input->post('tipe_menu'),
				'satuan'     	=> $this->input->post('satuan'),
				'harga_jual'   	=> $this->input->post('harga_jual'),
				'created_at'   	=> date('Y-m-d H:i:s'),
                'created_by'   	=> $this->data['users']->id,                
                'is_deleted'   	=> $this->input->post('status'),
			); 

			$insert = $this->daftar_menu_model->insert($data);

			if ($insert)
			{ 
				$barang = $this->input->post('barang');
				$jml 	= $this->input->post('jml');
				$menu_detail = [];
				foreach ($jml as $key => $val) {
				  if($jml[$key] > 0 ){
					$menu_detail[] = array(
						'menu' 			=> $insert,
						'barang' 		=> $barang[$key],
						'jml_pakai' 	=> $jml[$key],
					);
				  }
				}
				$this->db->insert_batch('daftar_menu_detail', $menu_detail);

				$this->session->set_flashdata('message', "Menu Resto Baru Berhasil Disimpan");
				redirect("menu");

			}else{

				$this->session->set_flashdata('message_error',"Menu Resto Baru Gagal Disimpan");
				redirect("menu");
			}
		}else{  
			
			$this->data['content'] 	 = 'admin/menu/create_v'; 
			$this->data['kategori']  = $this->kategori_model->getAllById(); 
			$this->data['cabang'] = $this->cabang_model->getAllByCabang(array('tipe_cbg' => 'M'));
			$this->data['stn']    = $this->satuan_model->getAllById();
			$this->data['barang'] 	 = $this->barang_model->getAllById(); 
			$this->load->view('admin/layouts/page',$this->data); 
		}
	} 

	public function edit($id)
	{ 
		$this->form_validation->set_rules('nama_menu',"Nama Harus diisi", 'trim|required');  
		
		if ($this->form_validation->run() === TRUE)
		{ 
			$data = array( 
				'id_cabang'     => $this->input->post('id_cabang'),
				'nama_menu'    	=> $this->input->post('nama_menu'),
				'label_menu'    => $this->input->post('label_menu'),
				'kelas_menu'   	=> $this->input->post('kelas_menu'),
				'kategori_menu' => $this->input->post('kategori_menu'),
				'tipe_menu'   	=> $this->input->post('tipe_menu'),
				'satuan'     	=> $this->input->post('satuan'),
				'harga_jual'   	=> $this->input->post('harga_jual'),
				'created_at'   	=> date('Y-m-d H:i:s'),
                'created_by'   	=> $this->data['users']->id,                
                'is_deleted'   	=> $this->input->post('status'),
			);

			$update = $this->daftar_menu_model->update($data,array("daftar_menu.id_menu"=>$id)); 
			
			if ($update)
			{  
				$this->daftar_menu_detail_model->delete(array("menu"=>$id));

				$barang = $this->input->post('barang');
				$jml 	= $this->input->post('jml');
				$menu_detail = [];
				foreach ($jml as $key => $val) {
				  if($jml[$key] > 0 ){
					$menu_detail[] = array(
						'menu' 			=> $id,
						'barang' 		=> $barang[$key],
						'jml_pakai' 	=> $jml[$key],
					);
				  }
				}
				$this->db->insert_batch('daftar_menu_detail', $menu_detail);

				$this->session->set_flashdata('message', "Menu Resto Berhasil Diperbaharui");
				redirect("menu","refresh");

			}else{

				$this->session->set_flashdata('message_error', "Menu Resto Gagal Diperbaharui");
				redirect("menu","refresh");
			}
		}else{
			if(!empty($_POST)){ 
				$this->session->set_flashdata('message_error',validation_errors());
				return redirect("menu/edit/".$id);	
			}else{
				$data = $this->daftar_menu_model->getAllById(array("daftar_menu.id_menu"=>$id));

				$barang = $this->barang_model->getAllById();
				$menu_barang = array();
				
				foreach ($barang as $key => $value) {
				$menu_detail = $this->daftar_menu_detail_model->getOneById(array("menu"=>$id, 'barang' => $value->id_barang));
					$new  = new stdclass();
					$new->id_barang  		= $value->id_barang;
					$new->nama_barang  		= $value->nama_barang;
					$new->stn_pesan_barang  = $value->stn_pesan_barang;
					$new->jml  				= (!empty($menu_detail->jml_pakai)?$menu_detail->jml_pakai:0);
					array_push($menu_barang, $new);
				}
				



				$this->data['id_cabang']        =   (!empty($data))?$data[0]->id_cabang:"";
				$this->data['nama_menu']      	=   (!empty($data))?$data[0]->nama_menu:"";
				$this->data['label_menu']  	 	=   (!empty($data))?$data[0]->label_menu:""; 
				$this->data['kategori_menu']  	=   (!empty($data))?$data[0]->kategori_menu:""; 
				$this->data['kelas_menu']  	 	=   (!empty($data))?$data[0]->kelas_menu:""; 
				$this->data['tipe_menu']  	 	=   (!empty($data))?$data[0]->tipe_menu:""; 
				$this->data['satuan']  	 		=   (!empty($data))?$data[0]->satuan:""; 
				$this->data['harga_jual']  	 	=   (!empty($data))?$data[0]->harga_jual:""; 
				$this->data['status']  	 		=   (!empty($data))?$data[0]->is_deleted:"";
				
				$this->data['content'] = 'admin/menu/edit_v';
				$this->data['kategori']  = $this->kategori_model->getAllById(); 
				$this->data['stn']  = $this->satuan_model->getAllById(); 
				$this->data['cabang'] = $this->cabang_model->getAllByCabang(array('tipe_cbg' => 'M'));
				$this->data['barang'] 	 = $menu_barang;
				$this->load->view('admin/layouts/page',$this->data); 
			}  
		}   
	} 

	public function dataList()
	{
	 	$columns = array( 
            0 => 'id_menu', 
            1 => 'id_cabang',
            2 => 'nama_menu',
            3 => 'label_menu',
            4 => 'kelas_menu',
            5 => 'kategori_menu',
            6 => 'tipe_menu',
            7 => 'satuan',
            8 => 'harga_jual',
            9 => '',
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
  		$limit = 0;
  		$start = 0;
        $totalData = $this->daftar_menu_model->getCountAllBy($limit,$start,$search,$order,$dir);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
       

        if(!empty($searchColumn[1]['search']['value'])){
        	$value = $searchColumn[1]['search']['value'];
        	$isSearchColumn = true;
         	$search['daftar_menu.id_cabang'] = $value;
		}

        if(!empty($searchColumn[2]['search']['value'])){
        	$value = $searchColumn[2]['search']['value'];
        	$isSearchColumn = true;
         	$search['daftar_menu.kategori_menu'] = $value;
        } 

      	if(!empty($searchColumn[3]['search']['value'])){
        	$value = $searchColumn[3]['search']['value'];
        	$isSearchColumn = true;
         	$search['daftar_menu.nama_menu'] = $value;
		}

    	if($isSearchColumn){
			$totalFiltered = $this->daftar_menu_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        }else{
        	$totalFiltered = $totalData;
        }  
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->daftar_menu_model->getAllBy($limit,$start,$search,$order,$dir);
		 
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   
            	$delete_url = "";
     		  
            	if($this->data['is_can_delete']){
                    if($data->is_deleted == 0){
                        $delete_url = "<button url='".base_url()."menu/destroy/".$data->id_menu."/".$data->is_deleted."'
                        class='btn btn-xs btn-success white delete' >Non Aktifkan
                        </button>";
                    }else{
                      $delete_url = "<button
                        url='".base_url()."menu/destroy/".$data->id_menu."/".$data->is_deleted."'
                        class='btn btn-xs btn-danger white delete'
                         >Aktifkan
                        </button>";
                    }
                }
                $id_menu = "<a href='".base_url()."menu/edit/".$data->id_menu."'><i class='fa fa-search'></i> ".$data->id_menu."</a>";

				$nestedData['id']       	 = $start+$key+1;
                $nestedData['id_menu']   	 = $id_menu;
                $nestedData['id_cabang']   	 = $data->id_cabang;
                $nestedData['nama_menu']     = $data->nama_menu;
                $nestedData['label_menu']    = $data->label_menu;
                $nestedData['kelas_menu']    = $data->kelas_menu;
                $nestedData['kategori_menu'] = $data->kategori_menu;
                $nestedData['tipe_menu']     = $data->tipe_menu;
                $nestedData['satuan']     	 = $data->satuan;
                $nestedData['harga_jual']  	 = number_format($data->harga_jual, 0, ".", ".");
           		$nestedData['action']        = $delete_url;   
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

	public function destroy(){
	    $response_data = array();
	    $response_data['status'] = false;
	    $response_data['msg'] = "";
	    $response_data['data'] = array();

	    $id =$this->uri->segment(3);
	    $is_deleted = $this->uri->segment(4);
	    if(!empty($id)){
	      $data = array(
	        'is_deleted' => ($is_deleted == 1)?0:1
	      );
	      $update = $this->daftar_menu_model->update($data,array("id_menu"=>$id));

	      $response_data['data'] = $data;
	      $response_data['status'] = true;  

	    }else{

	      $response_data['msg'] = "ID Harus Diisi";
	    
	    }

	    echo json_encode($response_data);
	 }
}
