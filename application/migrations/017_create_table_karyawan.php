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
class Migration_create_table_karyawan extends CI_Migration {


	public function up()
	{ 
		$table = "karyawan";
		$fields = array(
			'id'        => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			
			'KDPGW'         => [
				'type'           => 'VARCHAR(50)',
			],
			'nama'         => [
				'type'           => 'VARCHAR(50)',
			],
			'nickname'         => [
				'type'           => 'VARCHAR(50)',
			],
			'mulai_bekerja'         => [
				'type'           => 'VARCHAR(50)',
			],
			'alamat'               => [
				'type'           => 'TEXT(0)',
			],
			'alamat_saat_ini'               => [
				'type'           => 'TEXT(0)',
			],
			'KTP'         => [
				'type'           => 'VARCHAR(100)',
			],
			'tempat_lahir'         => [
				'type'           => 'VARCHAR(30)',
			],
			'tgl_lahir'         => [
				'type'           => 'VARCHAR(50)',
			],
			'agama'         => [
				'type'           => 'VARCHAR(50)',
			],
			'jenis_kelamin'         => [
				'type'           => 'VARCHAR(50)',
			],
			'no_hp'         => [
				'type'           => 'VARCHAR(50)',
			],
			'golongan_darah'         => [
				'type'           => 'VARCHAR(10)',
			],
			'sim'         => [
				'type'           => 'VARCHAR(3)',
			],
			'status_pernikahan'         => [
				'type'           => 'VARCHAR(50)',
			],
			'pendidikan_terakhir'         => [
				'type'           => 'VARCHAR(50)',
			],
			'instansi_pendidikan'         => [
				'type'           => 'VARCHAR(50)',
			],
			'staff_level'         => [
				'type'           => 'VARCHAR(50)',
			],
			'divisi'         => [
				'type'           => 'VARCHAR(50)',
			],
			'status_karyawan'         => [
				'type'           => 'VARCHAR(50)',
			],
			'photo'         => [
				'type'           => 'VARCHAR(100)',
			],
			'status'         => [
				'type'           => 'INT(3)',
			],
			'user_input'         => [
				'type'           => 'INT(10)',
			],
			'waktu_input'         => [
				'type'           => 'DATETIME(0)',
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
