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
class Migration_insert_master_function extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_function = array(
            array('name'=> 'Create','description' => 'Create'),
            array('name'=> 'Read','description' => 'Read'),
            array('name'=> 'Update','description' => 'Update'),
            array('name'=> 'Delete','description' => 'Delete'),
            array('name'=> 'Search','description' => 'Search')
        );
        $this->db->insert_batch('function', $data_function); 
	}


	public function down()
	{
		
	}

}