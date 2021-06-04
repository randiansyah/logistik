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
class Migration_create_table_transaksi extends CI_Migration {


	public function up()
	{ 
		$table = "transaksi";
		$fields = array(
			'id'        => [
				'type'           => 'INT(11)',
				'auto_increment' => TRUE,
				'unsigned'       => TRUE,
			],
			
			'id_transaksi'         => [
				'type'           => 'VARCHAR(100)',
				'null' => TRUE,
			],
			'kode_pelanggan'         => [
				'type'           => 'VARCHAR(50)',
				
			],
			'nama'         => [
				'type'           => 'VARCHAR(50)',
				
			],
			'telp'         => [
				'type'           => 'VARCHAR(50)',
			
			],
			'kirim_via'               => [
				'type'           => 'VARCHAR(50)',
				
			],
			'jenis_kendaraan'         => [
				'type'           => 'VARCHAR(100)',
				
			],
			'berat'         => [
				'type'      => 'INT(100)',
			
			],
			'tipe_berat'         => [
				'type'           => 'VARCHAR(2)',
			
			],

			'koli'         => [
				'type'           => 'INT(50)',
				
			],	
			'KDPROP_asal'         => [
				'type'           => 'INT(50)',
				
			],
			'KDKAB_asal'         => [
				'type'           => 'INT(50)',
				
			],	
			'KDPROP_tujuan'         => [
				'type'           => 'INT(50)',
				
			],
			'KDKAB_tujuan'         => [
				'type'           => 'INT(50)',
				
			],			
			'asal'         => [
				'type'           => 'VARCHAR(50)',
				
			],		
			'tujuan'         => [
				'type'           => 'VARCHAR(50)',
				
			],	
			'alamat'         => [
				'type'           => 'text(0)',
				
			],	
			'jenis_pembayaran'         => [
				'type'           => 'VARCHAR(50)',

			],	
			'jenis_pengiriman'         => [
				'type'           => 'VARCHAR(50)',
	
			],	
			'harga_barang'         => [
				'type'           => 'VARCHAR(100)',
				
			],
			'jenis_barang'         => [
				'type'           => 'text(0)',
			
			],		
			'packing'         => [
				'type'           => 'INT(2)',
				
			],		
			'harga_packing'         => [
				'type'           => 'INT(50)',
				
			],	
			'asuransi'         => [
				'type'           => 'int(1)',
				
			],
			'harga_asuransi'         => [
				'type'           => 'INT(50)',
			
			],
			'tipe'         => [
				'type'           => 'VARCHAR(50)',
			
			],	
			'pick_up'         => [
				'type'           => 'VARCHAR(50)',
				
			],	
			'delivery'         => [
				'type'           => 'VARCHAR(50)',
				
			],
			'jadwal_pickup'         => [
				'type'           => 'DATETIME(0)',
			
			],
			'jadwal_delivery'         => [
				'type'           => 'DATETIME(0)',
				
			],	
			'total_harga'         => [
				'type'           => 'INT(50)',
				
			],
			'posting'         => [
				'type'           => 'INT(2)',
				
			],
			'status'         => [
				'type'           => 'INT(2)',
				
			],
			'created_at'         => [
				'type'           => 'DATETIME(0)',
				
			],	
			'created_by'         => [
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
