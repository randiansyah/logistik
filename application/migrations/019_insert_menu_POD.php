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
class Migration_insert_menu_POD extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
         
                array(
                        'id'=>14,
                        'module_id'=>1, 
                        'name'=>'Purchase Order', 
                        'url'=>'#', 
                        'parent_id'=>1, 
                        'icon'=>"fa fa-shopping-cart", 
                        'sequence'=>4
                    ),
                array(
                        'id'=>15,
                        'module_id'=>1, 
                        'name'=>'Permintaan Pesanan', 
                        'url'=>'Permintaan_pesanan', 
                        'parent_id'=>14, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                  array(
                        'id'=>16,
                        'module_id'=>1, 
                        'name'=>'Buat Pesanan Baru', 
                        'url'=>'Pesanan', 
                        'parent_id'=>14, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>2
                    ),
                     array(
                        'id'=>17,
                        'module_id'=>1, 
                        'name'=>'Konfirmasi Pesanan', 
                        'url'=>'Pesanan', 
                        'parent_id'=>14, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>3
                    ),
           
                       
        );
        $this->db->insert_batch('menu', $data_menu); 
	} 

	public function down()
	{
		
	}

}