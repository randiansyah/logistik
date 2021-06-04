<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'core/Admin_Controller.php';
class Customer extends Admin_Controller {
  public function __construct()
  {
    parent::__construct();
    $this->load->model('customer_model'); 
  }
  public function index()
  {
    $this->load->helper('url');
    if($this->data['is_can_read']){
      $this->data['content'] = 'admin/pelanggan/list_v';   
    }else{
      $this->data['content'] = 'errors/html/restrict'; 
    }
    
    $this->load->view('admin/layouts/page',$this->data);  
  }

   public function dataList()
  {
    $columns = array( 
            0 => 'id', 
            1 => 'nama',
            2 => 'email',
            3 => 'jk',
            4 => 'telp',
            5 => 'alamat'
        );

      $order = $columns[$this->input->post('order')[0]['column']];
      $dir = $this->input->post('order')[0]['dir'];
      $search = array();
      $limit = 0;
      $start = 0;
      $totalData = $this->customer_model->getCountAllBy($limit,$start,$search,$order,$dir);       

        $searchColumn = $this->input->post('columns');
        $isSearchColumn = false;
        

      if($isSearchColumn){
        $totalFiltered = $this->customer_model->getCountAllBy($limit,$start,$search,$order,$dir); 
      }else{
        $totalFiltered = $totalData;
      }  
       
    $limit = $this->input->post('length');
    $start = $this->input->post('start');
    $datas = $this->customer_model->getAllBy($limit,$start,$search,$order,$dir);
     
        $new_data = array();
        if(!empty($datas))
        {
            foreach ($datas as $key=>$data)
            {   

           
            $nestedData['id']   = $start+$key+1;
            $nestedData['nama']          = $data->nama;
            $nestedData['email']    = $data->email; 
            $nestedData['jk']    = $data->jk; 
            $nestedData['telp']    = $data->telp; 
            $nestedData['alamat']    = $data->alamat;
            if($this->data['is_can_edit']){
          $nestedData['action'] = "<a href='".base_url()."Customer/edit/".$data->id."'><i class='fa fa-pencil'></i> Edit</a> <a href='#' 
                  url='".base_url()."Customer/destroy/".$data->id."'
                  class='delete' 
                   ><i class='fa fa-trash'></i>&nbsp;Hapus
                  </a>";
                }else{
                   $nestedData['action'] = "";
                }
         
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


  public function create(){
  $this->form_validation->set_rules('nama',"Nama Lengkap", 'trim|required'); 
   $date = date('y-m-d H:i:s');
  if($this->form_validation->run() === TRUE){
  
    $data = array (
    'nama' => $this->input->post('nama'),
    'alamat' => $this->input->post('alamat'),
    'email' => $this->input->post('email'),
    'jk' => $this->input->post('jenis_kelamin'),
    'telp' => $this->input->post('no_hp'),
    'status' => $this->input->post('status'),
    'user_input' => $this->input->post('user_input'),
    'waktu_input' => $this->input->post('waktu_input')
     );  
   
   
   
    $insert_barang = $this->customer_model->insert($data);
    if ($insert_barang)
      {  
        $this->session->set_flashdata('message', "Customer Baru Berhasil Disimpan");
        redirect("Customer");
      }else{
        $this->session->set_flashdata('message_error',"Customer Baru Gagal Disimpan");
        redirect("Customer");
      }     
                

  }else{
       
    $this->data['content'] = 'admin/pelanggan/create_v';
    $this->data['waktu_input'] = $date;
    $this->load->view('admin/layouts/page',$this->data);
  }
 }

  public function edit($id){
  $this->form_validation->set_rules('nama',"Nama Lengkap", 'trim|required'); 
   $date = date('y-m-d H:i:s');
  if($this->form_validation->run() === TRUE){
  
    $data = array (
    'nama' => $this->input->post('nama'),
    'alamat' => $this->input->post('alamat'),
    'email' => $this->input->post('email'),
    'jk' => $this->input->post('jenis_kelamin'),
    'telp' => $this->input->post('no_hp'),
    'status' => $this->input->post('status'),
    'user_input' => $this->input->post('user_input'),
    'waktu_input' => $this->input->post('waktu_input')
     );  
   
   
   
    $update = $this->customer_model->update($data,array("id"=>$id));
    if ($update)
      {  
        $this->session->set_flashdata('message', "Customer Berhasil di Edit");
        redirect("Customer");
      }else{
        $this->session->set_flashdata('message_error',"Customer Gagal Di edit");
        redirect("Customer");
      }     
                

  }else{
        $data = $this->customer_model->getAllById(array("id"=>$id));
        $this->data['nama'] =   (!empty($data))?$data[0]->nama:"";
        $this->data['email'] =   (!empty($data))?$data[0]->email:"";
        $this->data['telp'] =   (!empty($data))?$data[0]->telp:"";
        $this->data['alamat'] =   (!empty($data))?$data[0]->alamat:"";
       $this->data['jk'] =   (!empty($data))?$data[0]->jk:"";

    $this->data['content'] = 'admin/pelanggan/edit_v';
    $this->data['waktu_input'] = $date;
    $this->load->view('admin/layouts/page',$this->data);
  }
 }

  public function exportCSV()
    { 
       // file name 
       $filename = 'Pelanggan'.date('Ymd').'.csv'; 
       header("Content-Description: File Transfer"); 
       header("Content-Disposition: attachment; filename=$filename"); 
       header("Content-Type: application/csv; ");
       
       // get data 
       
       $datas = $this->customer_model->getAllById();

       // file creation 
       $file = fopen('php://output', 'w');
     
       $header = array("ID CUSTOMER","NAMA","EMAIL","JENIS KELAMIN","TELPON","ALAMAT"); 
       fputcsv($file, $header);
       foreach ($datas as $line){ 
         fputcsv($file,array($line->id_customer,$line->nama,$line->email,$line->jk,$line->telp,$line->alamat));
       }
       fclose($file); 
       exit; 
      } 

   public function destroy(){
    $response_data = array();
        $response_data['status'] = false;
        $response_data['msg'] = "";
        $response_data['data'] = array();   
    $id =$this->uri->segment(3);
    if(!empty($id)){
          $delete = $this->customer_model->delete(array("id"=>$id));
         
          $response_data['data'] = $data; 
          $response_data['status'] = true;
    }else{
      $response_data['msg'] = "ID Harus Diisi";
    }
    
        echo json_encode($response_data); 
  }
  


}
?>