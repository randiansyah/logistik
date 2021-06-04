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
class Migration_insert_master_menu_function extends CI_Migration {


	public function up()
	{ 
		for($j=1;$j<=100;$j++){
            for($i=1;$i<=5;$i++){
                $data_menu_function = array(
                    'menu_id' => $j, 
                    'function_id' => $i, 
                );
                $this->db->insert('menu_function', $data_menu_function);
            }       
        } 
	} 

	public function down()
	{
		
	}

}