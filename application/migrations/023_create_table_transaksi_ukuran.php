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
class Migration_create_table_transaksi_ukuran extends CI_Migration {


	public function up()
	{ 
		$table = "transaksi_ukuran";
		$fields = array(
			'id'        => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			
			'id_transaksi'         => [
				'type'           => 'VARCHAR(100)',
			],
			'panjang'         => [
				'type'           => 'INT(50)',
			],
			'lebar'         => [
				'type'           => 'VARCHAR(50)',
			],
			'tinggi'         => [
				'type'           => 'VARCHAR(50)',
			],
			'total_ukuran'               => [
				'type'           => 'VARCHAR(50)',
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
