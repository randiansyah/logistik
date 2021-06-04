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
class Migration_insert_master_menu extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
            array(
                    'id'=>1,
                    'module_id'=>1, 
                    'name'=>'root', 
                    'url'=>'#', 
                    'parent_id'=>0, 
                    'icon'=>" ", 
                    'sequence'	=>0
                ),
            array(
                    'id'=>2,
                    'module_id'=>1, 
                    'name'=>'Dashboard', 
                    'url'=>'dashboard', 
                    'parent_id'=>1, 
                    'icon'=>"fa fa-dashboard", 
                    'sequence'=>1
                ),
            array(
                    'id'=>3,
                    'module_id'=>1, 
                    'name'=>'Sistem Akses', 
                    'url'=>'#', 
                    'parent_id'=>1, 
                    'icon'=>"fa fa-gear", 
                    'sequence'=>2
                ),
                array(
                        'id'=>4,
                        'module_id'=>1, 
                        'name'=>'Role', 
                        'url'=>'role', 
                        'parent_id'=>3, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                array(
                        'id'=>5,
                        'module_id'=>1, 
                        'name'=>'Privileges', 
                        'url'=>'privileges', 
                        'parent_id'=>3, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>2
                    ),
            array(
                    'id'=>6,
                    'module_id'=>1, 
                    'name'=>'Pengguna', 
                    'url'=>'#', 
                    'parent_id'=>1, 
                    'icon'=>"fa fa-users", 
                    'sequence'	=>3
                ), 
                array(
                        'id'=>7,
                        'module_id'=>1, 
                        'name'=>'Data Pengguna', 
                        'url'=>'user', 
                        'parent_id'=>6, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                       
        );
        $this->db->insert_batch('menu', $data_menu); 
	} 

	public function down()
	{
		
	}

}