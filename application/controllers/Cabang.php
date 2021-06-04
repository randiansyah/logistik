<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Cabang extends Admin_Controller {
 	public function __construct()
	{
		parent::__construct();
		$this->load->model('wilayah_model'); 
		$this->load->model('cabang_model'); 
        $this->load->model('barang_model'); 
        $this->load->model('stok_barang_model'); 
    }
    
	public function index()
	{
		$this->load->helper('url');
		if($this->data['is_can_read']){
			$this->data['content'] = 'admin/cabang/list_v'; 	
            $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  			
		}else{
			$this->data['content'] = 'errors/html/restrict'; 
		}
		
		$this->load->view('admin/layouts/page',$this->data);  
	}

    public function create()
    { 
        $kdcbg = $this->uri->segment(2);
        $this->form_validation->set_rules('nama',"Name Harus Diisi", 'trim|required');   

        if ($this->form_validation->run() === TRUE)
        { 
            $KDPROP  = $this->input->post('kdprop');
            $KDKAB   = $this->input->post('kdkab');
            $wilayah = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP, 'KDKAB' => $KDKAB));
            $idcbg = $this->cabang_model->getKode(array('idcbg' => $this->input->post('tipe')));
            $data = array( 
                'KDPROP'       => $this->input->post('kdprop'),
                'KDKAB'        => $this->input->post('kdkab'),
                'NMPROP'       => $wilayah->NMPROP,
                'NMKAB'        => $wilayah->NMKAB,             
                'kdcbg'        => strtoupper($this->input->post('kdcbg')),
                'idcbg'        => $this->input->post('tipe').$idcbg,
                'nama_cbg'     => $this->input->post('nama'),
                'tipe_cbg'     => $this->input->post('tipe'),
                'stokis_cbg'   => (!$this->input->post('stokis_cbg')?NULL:$this->input->post('stokis_cbg')),
                'produksi_cbg' => (!$this->input->post('produksi_cbg')?NULL:$this->input->post('produksi_cbg')),
                'gudang_pusat' => (!$this->input->post('gudang_pusat')?NULL:$this->input->post('gudang_pusat')),
                'alamat_cbg'   => (!$this->input->post('alamat')?NULL:$this->input->post('alamat')),
                'nama_kontak'  => (!$this->input->post('nama_kontak')? NULL:$this->input->post('nama_kontak')),
                'telp_kontak'  => (!$this->input->post('telp_kontak')?0:$this->input->post('telp_kontak')),
                'created_at'   => date('Y-m-d H:i:s'),
                'created_by'   => $this->data['users']->id,                
                'is_deleted'   => $this->input->post('status'),                
            ); 

            $insert = $this->cabang_model->insert($data);

            if ($insert)
            {  
                $barang = $this->barang_model->getAllbyId();
                $data_stok = [];
                if(!empty($barang) && 
                    $this->input->post('tipe') == 'M' || 
                        $this->input->post('tipe') == 'F' || 
                            $this->input->post('tipe') == 'H' || 
                                $this->input->post('tipe') == 'S' ){
                    foreach ($barang as $key => $value) {
                        $data_stok[] = array(
                            'stok_barang'     => $value->id_barang,
                            'stok_stn'        => $value->stn_barang,
                            'stok_stn_pesan'  => $value->stn_pesan_barang,
                            'stok_jml_stn'    => $value->jml_barang,
                            'stok_cabang'     => strtoupper($this->input->post('kdcbg')),
                            'stok_sisa'       => 0,
                            'stok_konversi'   => '0 '.$value->stn_barang.' 0 '.$value->stn_pesan_barang,
                        );
                    }
                    $this->db->insert_batch('stok_barang', $data_stok);
                } 
                $this->session->set_flashdata('message', "Data cabang Baru Berhasil Disimpan");
                redirect("cabang");

            }else{

                $this->session->set_flashdata('message_error',"Data cabang Baru Gagal Disimpan");
                redirect("cabang");
            }
        }else{  
            $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
            $this->data['stokis'] = $this->cabang_model->getAllByCabang(array('tipe_cbg' => 'S'));  
            $this->data['produksi'] = $this->cabang_model->getAllByCabang(array('tipe_cbg' => 'P'));  
            $this->data['gudang'] = $this->cabang_model->getAllByCabang(array('tipe_cbg' => 'G'));
            $this->data['content'] = 'admin/cabang/create_v'; 
            $this->load->view('admin/layouts/page',$this->data); 
        }
    } 

    public function edit($id)
    { 
        $this->form_validation->set_rules('nama',"Name Harus Diisi", 'trim|required');   

        if ($this->form_validation->run() === TRUE)
        { 
            $KDPROP  = $this->input->post('kdprop');
            $KDKAB   = $this->input->post('kdkab');
            $wilayah = $this->wilayah_model->getOneBy(array('KDPROP' => $KDPROP, 'KDKAB' => $KDKAB));
            $idcbg = $this->cabang_model->getKode(array('tipe_cbg' => $this->input->post('tipe')));
            $data = array( 
                'KDPROP'       => $this->input->post('kdprop'),
                'KDKAB'        => $this->input->post('kdkab'),
                'NMPROP'       => $wilayah->NMPROP,
                'NMKAB'        => $wilayah->NMKAB,             
                'nama_cbg'     => $this->input->post('nama'),
                'tipe_cbg'     => $this->input->post('tipe'),
                'stokis_cbg'   => (!$this->input->post('stokis')?NULL:$this->input->post('stokis')),
                'produksi_cbg' => (!$this->input->post('produksi')?NULL:$this->input->post('produksi')),
                'gudang_pusat' => (!$this->input->post('gudang_pusat')?NULL:$this->input->post('gudang_pusat')),
                'alamat_cbg'   => (!$this->input->post('alamat')?NULL:$this->input->post('alamat')),
                'nama_kontak'  => (!$this->input->post('nama_kontak')? NULL:$this->input->post('nama_kontak')),
                'telp_kontak'  => (!$this->input->post('telp_kontak')?0:$this->input->post('telp_kontak')),
                'created_at'   => date('Y-m-d H:i:s'),
                'created_by'   => $this->data['users']->id,                
                'is_deleted'   => $this->input->post('status'),                
            ); 

            $update = $this->cabang_model->update($data, array('idcbg' => $id));

            if ($update)
            {  
                $this->session->set_flashdata('message', "Perubahan Data cabang Berhasil");
                redirect("cabang");

            }else{

                $this->session->set_flashdata('message_error',"Perubahan Data cabang Gagal");
                redirect("cabang");
            }
        }else{ 
            if(!empty($_POST)){ 
                $this->session->set_flashdata('message_error',validation_errors());
                return redirect("cabang/edit/".$id);    
            }else{ 
                $this->data['data_provinsi'] = $this->wilayah_model->getAllProvince();  
                $this->data['stokis'] = $this->cabang_model->getAllByCabang(array('tipe_cbg' => 'S'));  
                $this->data['produksi'] = $this->cabang_model->getAllByCabang(array('tipe_cbg' => 'P'));  
                $this->data['gudang'] = $this->cabang_model->getAllByCabang(array('tipe_cbg' => 'G'));
                $data = $this->cabang_model->getAllById(array('idcbg' => $id));
                $this->data['KDPROP'] = (!empty($data))?$data[0]->KDPROP:"";
                $this->data['KDKAB'] = (!empty($data))?$data[0]->KDKAB:"";
                $this->data['kdcbg'] = (!empty($data))?$data[0]->kdcbg:"";
                $this->data['nama'] = (!empty($data))?$data[0]->nama_cbg:"";
                $this->data['tipe'] = (!empty($data))?$data[0]->tipe_cbg:"";
                $this->data['stokis_cbg'] = (!empty($data))?$data[0]->stokis_cbg:"";
                $this->data['produksi_cbg'] = (!empty($data))?$data[0]->produksi_cbg:"";
                $this->data['gudang_pusat'] = (!empty($data))?$data[0]->gudang_pusat:"";
                $this->data['alamat'] = (!empty($data))?$data[0]->alamat_cbg:"";
                $this->data['nama_kontak'] = (!empty($data))?$data[0]->nama_kontak:"";
                $this->data['telp_kontak'] = (!empty($data))?$data[0]->telp_kontak:"";
                $this->data['status'] = (!empty($data))?$data[0]->is_deleted:"";

                $this->data['content'] = 'admin/cabang/edit_v'; 
                $this->load->view('admin/layouts/page',$this->data); 
            }   
        }
    }

	public function dataList()
	{
	 	$columns = array( 
            0 => 'idcbg', 
            1 => 'kdcbg',
            2 => 'NMPROP', 
            3 => 'NMKAB', 
            4 => 'nama_cbg',
            5 => 'tipe_cbg',
            6 => 'stokis_cbg',
            7 => 'produksi_cbg',
            8 => 'gudang_pusat',
            9 => '',
        );

        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  		$search = array();
  		$limit = 0;
  		$start = 0;
        $totalData = $this->cabang_model->getCountAllBy($limit,$start,$search,$order,$dir);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        
        if(!empty($searchColumn[1]['search']['value'])){
            $value = $searchColumn[1]['search']['value'];
            $isSearchColumn = true;
            $search['cabang.KDPROP'] = $value;
        }  

        if(!empty($searchColumn[2]['search']['value'])){
            $value = $searchColumn[2]['search']['value'];
            $isSearchColumn = true;
            $search['cabang.KDKAB'] = $value;
        }

        if(!empty($searchColumn[3]['search']['value'])){
            $value = $searchColumn[3]['search']['value'];
            $isSearchColumn = true; 
            $search['cabang.tipe_cbg'] = $value;
        }

        if(!empty($searchColumn[4]['search']['value'])){
            $value = $searchColumn[4]['search']['value'];
            $isSearchColumn = true;
            $search['cabang.nama_cbg'] = $value;
        }

        if($isSearchColumn){
            $totalFiltered = $this->cabang_model->getCountAllBy($limit,$start,$search,$order,$dir); 
        }else{
            $totalFiltered = $totalData;
        } 
       
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
		$datas = $this->cabang_model->getAllBy($limit,$start,$search,$order,$dir);
		 
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   
            	$delete_url = "";
     		  
            	if($this->data['is_can_delete']){
                    if($data->is_deleted == 0){
                        $delete_url = "<button url='".base_url()."cabang/destroy/".$data->idcbg."/".$data->is_deleted."'
                        class='btn btn-xs btn-success white delete' >Non Aktifkan
                        </button>";
                    }else{
                      $delete_url = "<button
                        url='".base_url()."cabang/destroy/".$data->idcbg."/".$data->is_deleted."'
                        class='btn btn-xs btn-danger white delete'
                         >Aktifkan
                        </button>";
                    }
                }
				
                $kdcbg = "<a href='".base_url()."cabang/edit/".$data->idcbg."'><i class='fa fa-search'></i> ".$data->kdcbg."</a>";

                $nestedData['id']         	= $start+$key+1;
                $nestedData['kdcbg']	  	= $kdcbg;
                $nestedData['idcbg']	  	= $data->idcbg;
                $nestedData['NMPROP']	  	= $data->NMPROP;
                $nestedData['NMKAB']	  	= $data->NMKAB;
                $nestedData['nama_cbg']     = $data->nama_cbg; 
                $nestedData['tipe_cbg']     = $data->tipe_cbg; 
                $nestedData['stokis_cbg'] 	= $data->stokis_cbg;
                $nestedData['produksi_cbg'] = $data->produksi_cbg;
                $nestedData['gudang_pusat'] = $data->gudang_pusat;
                $nestedData['status']       = $delete_url;
                $new_data[]               	= $nestedData; 
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
          $update = $this->cabang_model->update($data,array("idcbg"=>$id));

          $response_data['data'] = $data;
          $response_data['status'] = true;  

        }else{

          $response_data['msg'] = "ID Harus Diisi";
        
        }

        echo json_encode($response_data);
    }

}
