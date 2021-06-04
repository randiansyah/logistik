<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');
	
 	function uploadFile($file_name, $dir,$prefix_file,$ext=''){   
        $CI =& get_instance();
        $return_file_name="";
        $config['upload_path']          = $dir;
        $config['allowed_types']        = '*'; 
        if($ext != ''){
            $ext = $ext;
        }else{
            $ext = ".jpg";
        }
        $config['file_name'] = $prefix_file."_".time().$ext;

        $return = array();
        $return['status'] = FALSE;
        $return['message'] = "";
        $CI->load->library('upload');
        $CI->upload->initialize($config);
        if ($CI->upload->do_upload($file_name)){   
            $upload_data = $CI->upload->data(); 
            $return_file_name = $config['file_name']; 
            $return['status'] = TRUE;
            $return['message'] = $return_file_name;
        }else{
            $return['status'] = FALSE;  
            $return['message'] =  $CI->upload->display_errors();
        }
        return $return;
    }