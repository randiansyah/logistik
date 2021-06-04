<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends CI_Controller {
 	public function __construct()
	{
		parent::__construct();
		$this->data = array();          
		$this->data['users'] = array();
		if (!$this->ion_auth->logged_in())
		{
			redirect('auth/login', 'refresh');
		}else{
			$this->data['users']= $this->ion_auth->user()->row();
			$this->data['users_groups']=   $this->ion_auth->get_users_groups($this->data['users']->id)->row();
			$createpage = $this->uri->segment(1);
			$this->load->model("menu_model");
		$idHalaman = $this->menu_model->getMenuOneBy(array('url' => $createpage));
		

		} 

		$this->data['page'] = "";  
		$this->data['parent_page_name'] = "";  
	
		$this->data['is_superadmin'] = false; 
		$this->data['is_can_read'] = false;
		$this->data['is_can_rescheduled'] = false;
		$this->data['is_can_approval'] = false;
		$this->data['is_can_create'] = false;
		$this->data['is_can_edit'] = false;
		$this->data['is_can_delete'] = false;
		$this->data['is_can_search'] = false;
		$this->data['is_can_download'] = false;
		$this->load->model("menu_model");
		
		if ($this->ion_auth->in_group(1))
		{
			$this->data['is_superadmin'] = true;
		}
		if (!$this->input->is_ajax_request()) {
			$this->data['menu'] = $this->loadMenu();
		}else{
			
			$this->data['menu'] = $this->loadMenu();
		}  

		if ($this->data['is_superadmin'])
		{
			
			$this->data['is_can_read'] = true;
			$this->data['is_can_edit'] = true;
			$this->data['is_can_create'] = true;
			$this->data['is_can_delete'] = true;
			$this->data['is_can_rescheduled'] = true;
			$this->data['is_can_approval'] = true;
			$this->data['is_can_search'] = true;
			$this->data['is_can_download'] = true;
		}else{ 
			$this->load->model("privilleges_model");
			$dataPrivilleges = $this->privilleges_model->getOneBy(array(
				"menu_id"=>$idHalaman,
				"role_id"=>$this->data['users_groups']->id
			)); 

			$this->data['is_can_create'] = ($this->isInPrivilleges($dataPrivilleges,1));
			$this->data['is_can_read'] = ($this->isInPrivilleges($dataPrivilleges,2));
			$this->data['is_can_edit'] = ($this->isInPrivilleges($dataPrivilleges,3));
			$this->data['is_can_delete'] = ($this->isInPrivilleges($dataPrivilleges,4));
			$this->data['is_can_search'] = ($this->isInPrivilleges($dataPrivilleges,5));
			$this->data['is_can_approval'] = ($this->isInPrivilleges($dataPrivilleges,6)); 
			$this->data['is_can_download'] = ($this->isInPrivilleges($dataPrivilleges,7));
		}    
	} 
		private function isInPrivilleges($data,$id){
		if(!empty($data)){
			for ($i=0; $i < count($data) ; $i++) { 
				if(isset($data[$i]) && $data[$i]->function_id == $id){
					return true;
				}
			}
		}
		
		return false;
	}
	private function createTree($parent, $menu,$parent_id,$path_active_name){

	 	$html = "";
	   	if (isset($menu['parents'][$parent])) {
	      	if($parent == 1){
	      		$html .= '<ul class="sidebar-menu" data-widget="tree"> ';
	      	}else{
	      		$class = ($parent==$parent_id)?"style='display:block;'":'';
	      			      	 	$html .= '<ul class="treeview-menu">';
	      	}
	       	foreach ($menu['parents'][$parent] as $itemId) { 
	       		$id = $menu['items'][$itemId]['id'];
	       		$url = $menu['items'][$itemId]['url'];
	       		$urlText = $menu['items'][$itemId]['url-text'];
	       		$icon = $menu['items'][$itemId]['icon'];
	       		$name = $menu['items'][$itemId]['name'];
	          	if(!isset($menu['parents'][$itemId])) { 
	          		$class = ($path_active_name == strtolower($urlText) )?"class ='active'":' ';

	             	$html .= '<li '.$class.'>
     				<a href="'.$url.'"><i class="fa '.$icon.'"></i> <span>'.$name.'</span></a>
     				</li>'; 
	          	}else {
	          		$class = ($id==$parent_id)?"active":'';
		         	$html .='<li class="treeview '.$class.'"><a href="#">
				            <i class="fa '.$icon.'"></i> <span>'.$name.'</span>
				            <span class="pull-right-container">
				              <i class="fa fa-angle-left pull-right"></i>
				            </span>
				          </a>';
	            	$html .= $this->createTree($itemId, $menu,$parent_id,$path_active_name); 
	            	$html .= "</li>";
	          	}  
	       }
	       $html .= "</ul>"; 
	   }
	   return $html;
	}
	private function loadMenu(){ 
		if($this->data['is_superadmin']){
			$menus = $this->menu_model->getMenuSuperadmin();	
		}else{ 
			$menus = $this->menu_model->getMenuPrivilleges(array("role_id"=>$this->data['users_groups']->id));	
		}
		if(empty($menus)) return "";

		$new_menus = array();

		foreach ($menus as $key => $value) {
			$new_menus[$value->id] = array();
			$new_menus[$value->id]['id'] = $value->id;
			$new_menus[$value->id]['name'] = $value->name;
			$new_menus[$value->id]['url'] = base_url().$value->url;
			$new_menus[$value->id]['url-text'] = $value->url;
			$new_menus[$value->id]['parent_id'] = $value->parent_id;
			$new_menus[$value->id]['icon'] = $value->icon;
		}
	 	 
	  	$tree_menu = array(
			'items' => array(),
			'parents' => array()
		);
		foreach ($new_menus as $a){ 
		  	$tree_menu['items'][$a['id']] = $a;
			// Creates list of all items with children
			$tree_menu['parents'][$a['parent_id']][] = $a['id'];
		}  
		$path_active_name = $this->uri->segment(1) ;
		if(!empty($this->uri->segment(2))){ 
			if($this->uri->segment(2) !== "create" && $this->uri->segment(2) !== "edit"  && $this->uri->segment(2) !== "detail" && $this->uri->segment(2) !== "importExcel" && $this->uri->segment(2) !== "exportJson"){
					$path_active_name = $this->uri->segment(1)."/".$this->uri->segment(2);
			} 
		}  
		
	 	$data_parent = $this->menu_model->getParentIdBy(array("URL"=>$path_active_name));
	 	$data_menu = $this->menu_model->getDetailMenuBy(array("URL"=>$path_active_name));
	  
		$parent_id = (!empty($data_parent))?$data_parent->parent_id:0;
		if($data_parent){
			$parent = $this->menu_model->getParentIdBy(array("id"=>$data_parent->parent_id));	
		}
 		
		$this->data['parent_page_name']  = (!empty($parent))?$parent->name:"";
		$this->data['page'] = (!empty($data_menu))?$data_menu->name:"";
		$this->data['page_id'] = (!empty($data_menu))?$data_menu->id:"";
		$this->session->set_userdata(array("page_id"=>$this->data['page_id']));
		return $this->createTree(1, $tree_menu,$parent_id,$path_active_name); 
	} 
	
}
