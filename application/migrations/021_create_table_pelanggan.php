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
class Migration_create_table_pelanggan extends CI_Migration {


	public function up()
	{ 
		$table = "customer";
		$fields = array(
			'id'        => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			
			'nama'         => [
				'type'           => 'VARCHAR(50)',
			],
			'email'         => [
				'type'           => 'VARCHAR(50)',
			],
			'jk'         => [
				'type'           => 'VARCHAR(50)',
			],
			'telp'         => [
				'type'           => 'VARCHAR(50)',
			],
			'alamat'               => [
				'type'           => 'TEXT(0)',
			],
			'status'         => [
				'type'           => 'INT(3)',
			],
			'user_input'         => [
				'type'           => 'INT(10)',
			],
			'waktu_input'         => [
				'type'           => 'DATETIME(0)',
				'null' => TRUE,
			],
			'is_deleted'         => [
				'type'           => 'INT(10)',
			],																
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_key('uri');
		$this->dbforge->create_table($table);
	 
	}


	public function down()
	{

	}

}
