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
class Migration_create_table_menu extends CI_Migration {


	public function up()
	{ 
		$table = "menu";
		$fields = array(
			'id'           => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			'module_id'      => [
				'type' => 'INT(10)',
			],
			'name'          => [
				'type' => 'VARCHAR(255)',
			],
			'url'        => [
				'type' => 'VARCHAR(255)',
			],
			'parent_id' => [
				'type' => 'INT(11)',
			],
			'icon' => [
				'type' => 'VARCHAR(255)',
			],
			'sequence' => [
				'type' => 'INT(11)',
			],
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('uri');
		$this->dbforge->create_table($table);
	 
	}


	public function down()
	{
		$table = "menu";
		if ($this->db->table_exists($table))
		{
			$this->db->query(drop_foreign_key($table, 'api_key'));
			$this->dbforge->drop_table($table);
		}
	}

}
