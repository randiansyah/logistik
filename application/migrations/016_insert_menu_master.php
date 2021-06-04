<?php
/**
 * @author   Natan Felles <natanfelles@gmail.com>
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Migration_create_table_api_limits
 *
 * @property CI_DB_forge         $dbforge
 * @property CI_DB_query_builder $db
 */
class Migration_insert_menu_master extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
         
                array(
                        'id'=>8,
                        'module_id'=>1, 
                        'name'=>'Master Data', 
                        'url'=>'#', 
                        'parent_id'=>1, 
                        'icon'=>"fa fa-list", 
                        'sequence'=>4
                    ),
                array(
                        'id'=>9,
                        'module_id'=>1, 
                        'name'=>'Data Karyawan', 
                        'url'=>'Karyawan', 
                        'parent_id'=>8, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                  array(
                        'id'=>10,
                        'module_id'=>1, 
                        'name'=>'Data Customer', 
                        'url'=>'Customer', 
                        'parent_id'=>8, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>2
                    ),
                     array(
                        'id'=>11,
                        'module_id'=>1, 
                        'name'=>'Data Vendor', 
                        'url'=>'Vendor', 
                        'parent_id'=>8, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>3
                    ),
                      array(
                        'id'=>12,
                        'module_id'=>1, 
                        'name'=>'Daftar Harga', 
                        'url'=>'Daftar_harga', 
                        'parent_id'=>8, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>4
                    ),
                        array(
                        'id'=>13,
                        'module_id'=>1, 
                        'name'=>'Data Wilayah', 
                        'url'=>'Wilayah', 
                        'parent_id'=>8, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>5
                    ),
           
                       
        );
        $this->db->insert_batch('menu', $data_menu); 
	} 

	public function down()
	{
		
	}

}