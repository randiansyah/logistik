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
class Migration_insert_menu_delivery extends CI_Migration {


	public function up()
	{ 
		// insert function value
		 $data_menu = array(
         
                array(
                        'id'=>18,
                        'module_id'=>1, 
                        'name'=>'Delivery', 
                        'url'=>'#', 
                        'parent_id'=>1, 
                        'icon'=>"fa fa-clock-o", 
                        'sequence'=>6
                    ),
                array(
                        'id'=>19,
                        'module_id'=>1, 
                        'name'=>'Kirim Pesanan', 
                        'url'=>'Kirim_pesanan', 
                        'parent_id'=>18, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                  array(
                        'id'=>20,
                        'module_id'=>1, 
                        'name'=>'Invoice Baru', 
                        'url'=>'invoice_baru', 
                        'parent_id'=>18, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>2
                    ),
                     array(
                        'id'=>21,
                        'module_id'=>1, 
                        'name'=>'Pembayaran Invoice', 
                        'url'=>'pembayaran_invoice', 
                        'parent_id'=>18, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>3
                    ),
                     array(
                        'id'=>22,
                        'module_id'=>1, 
                        'name'=>'Customer Support', 
                        'url'=>'#', 
                        'parent_id'=>1, 
                        'icon'=>"fa fa-user-circle-o", 
                        'sequence'=>7
                    ),
                        array(
                        'id'=>23,
                        'module_id'=>1, 
                        'name'=>'Jadwal Pickup', 
                        'url'=>'Jadwal_pickup', 
                        'parent_id'=>22, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                        array(
                        'id'=>24,
                        'module_id'=>1, 
                        'name'=>'SPB Barang Masuk', 
                        'url'=>'SPB_barang_masuk', 
                        'parent_id'=>22, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>2
                    ),
                     array(
                        'id'=>25,
                        'module_id'=>1, 
                        'name'=>'SPB Barang Keluar', 
                        'url'=>'SPB_barang_keluar', 
                        'parent_id'=>22, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>3
                    ),
                      array(
                        'id'=>26,
                        'module_id'=>1, 
                        'name'=>'Pickadel', 
                        'url'=>'#', 
                        'parent_id'=>1, 
                        'icon'=>"fa fa-truck", 
                        'sequence'=>8
                    ),
                       array(
                        'id'=>27,
                        'module_id'=>1, 
                        'name'=>'List Pickup', 
                        'url'=>'Pickup', 
                        'parent_id'=>26, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                         array(
                        'id'=>28,
                        'module_id'=>1, 
                        'name'=>'List Delivery', 
                        'url'=>'Pickup', 
                        'parent_id'=>26, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>2
                    ),
                          array(
                        'id'=>29,
                        'module_id'=>1, 
                        'name'=>'List Delivery', 
                        'url'=>'list_delivery', 
                        'parent_id'=>26, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>4
                    ),
                        array(
                        'id'=>30,
                        'module_id'=>1, 
                        'name'=>'SPB Barang Keluar', 
                        'url'=>'list_SPB_barang_keluar', 
                        'parent_id'=>26, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>4
                    ),
                        array(
                        'id'=>31,
                        'module_id'=>1, 
                        'name'=>'Invoice', 
                        'url'=>'List_invoice', 
                        'parent_id'=>26, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>5
                    ),
                 
                      array(
                        'id'=>32,
                        'module_id'=>1, 
                        'name'=>'Warehouse', 
                        'url'=>'#', 
                        'parent_id'=>1, 
                        'icon'=>"fa fa-home", 
                        'sequence'=>9
                    ),
                          array(
                        'id'=>33,
                        'module_id'=>1, 
                        'name'=>'SPB Barang Masuk', 
                        'url'=>'List_SPB_barang_masuk', 
                        'parent_id'=>32, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                         array(
                        'id'=>34,
                        'module_id'=>1, 
                        'name'=>'SPB Barang Keluar', 
                        'url'=>'List_SPB_barang_keluar', 
                        'parent_id'=>32, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>2
                    ),
                        array(
                        'id'=>35,
                        'module_id'=>1, 
                        'name'=>'Purchase Order', 
                        'url'=>'List_PO', 
                        'parent_id'=>32, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>3
                    ),
                        array(
                        'id'=>36,
                        'module_id'=>1, 
                        'name'=>'Arsip', 
                        'url'=>'#', 
                        'parent_id'=>1, 
                        'icon'=>"fa fa-file", 
                        'sequence'=>10
                    ),
                        array(
                        'id'=>37,
                        'module_id'=>1, 
                        'name'=>'Laporan Tunggakan', 
                        'url'=>'laporan_tunggakan', 
                        'parent_id'=>36, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                          array(
                        'id'=>38,
                        'module_id'=>1, 
                        'name'=>'Rekapitulasi Tunggakan', 
                        'url'=>'rekapitulasi_tunggakan', 
                        'parent_id'=>36, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>2
                    ),
                          array(
                        'id'=>39,
                        'module_id'=>1, 
                        'name'=>'Accounting', 
                        'url'=>'#', 
                        'parent_id'=>1, 
                        'icon'=>"fa fa-calculator", 
                        'sequence'=>10
                    ),
                           array(
                        'id'=>40,
                        'module_id'=>1, 
                        'name'=>'Saldo Awal', 
                        'url'=>'Saldo_awal', 
                        'parent_id'=>39, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>1
                    ),
                       array(
                        'id'=>41,
                        'module_id'=>1, 
                        'name'=>'Jurnal', 
                        'url'=>'Jurnal', 
                        'parent_id'=>39, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>2
                    ),
                      array(
                        'id'=>42,
                        'module_id'=>1, 
                        'name'=>'Buku Besar', 
                        'url'=>'Buku_besar', 
                        'parent_id'=>39, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>3
                    ),
                      array(
                        'id'=>43,
                        'module_id'=>1, 
                        'name'=>'Neraca Saldo', 
                        'url'=>'Neraca_saldo', 
                        'parent_id'=>39, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>4
                    ),
                        array(
                        'id'=>44,
                        'module_id'=>1, 
                        'name'=>'Jurnal Penyesuaian', 
                        'url'=>'Jurnal_penyesuian', 
                        'parent_id'=>39, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>5
                    ),
                        array(
                        'id'=>45,
                        'module_id'=>1, 
                        'name'=>'Neraca', 
                        'url'=>'Neraca', 
                        'parent_id'=>39, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>6
                    ),
                        array(
                        'id'=>46,
                        'module_id'=>1, 
                        'name'=>'Laba Rugi', 
                        'url'=>'Laba_rugi', 
                        'parent_id'=>39, 
                        'icon'=>"fa fa-circle-o", 
                        'sequence'=>7
                    ),
           
                       
        );
        $this->db->insert_batch('menu', $data_menu); 
	} 

	public function down()
	{
		
	}

}