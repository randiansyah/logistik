<html>
	<head>
		<title></title>
	 <style type="text/css">
  @page { 
  	margin-left: 50px;
   margin-right: 50px;
   margin-top: -50px;
   margin-bottom:10px;

   }
      @font-face {
  font-family: 'Open Sans';
  font-style: normal;
  font-weight: normal;
  src: url(http://themes.googleusercontent.com/static/fonts/opensans/v8/cJZKeOuBrn4kERxqtaUH3aCWcynf_cDxXwCLxiixG1c.ttf) format('truetype');
}   
        body{
         font-family: Arial,sans-serif;           
        }
pull-right {
    float: right;
}
h3{
	font-size: 30px;
	color:#0d5ea2;
	margin-bottom: 0px;
}
h4{
	font-size: 16px;
	font-weight:bold;
	margin-bottom: -1px;

}
atur-margin{
	text-align: right;
}
p{
	width: 20px;
}
table.t01 {
text-align: left;width:100%;
font-size:12px;
text-align:center;


}
table.t01 thead th{
	background-color:#939394;
	height: 50px;
	color: #ffffff;
	font-weight:700;
	border:1px solid #333333;

}
table.t01 tbody td{

border-bottom:1px solid #333333;
	border-left:1px solid #333333;


}
td.hb{
		border-right:1px solid #333333;
}
td.tdfoot{
	border-bottom:1px solid #333333;
	border-right:1px solid #333333;
	border-left:1px solid #333333;
}



 </style>
	</head>
	<body>
      <table style="text-align: left;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px" border="0">        
    <tr>
        <td width="70%"><br><br><br><br><br><br><img src="assets/images/logo1.png" width="90px" style="margin-top: 30px;">
        	<br>
        	<h4>CV. iP LOGISTINDO</h4>
        	Komp.Medan Resort City No.19<br>
        	Jl. Merci Raya - Medan Johor<br>
        	Sumatera Utara
        </td>
        <td class="inv"><div class="atur-margin"></div><b><h3>INVOICE</h3>
Invoice No.<?php echo $inv?><br>
Tanggal     : <?php echo date('d M Y')?><br>
Jatuh Tempo : <?php echo $tgl_jatuh_tempo?>
</div>
        </td>
       
       
    </tr>  
   
</table>
<br>
 <table style="text-align: left;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px">        
   
    <tr>
    	 <td  style="background-color: #0d5ea2;color: #ffffff;font-weight: bold;">
        	Ditagih Kepada
        </td>
       
    </tr> 
   <tr>
   	<td>
   			<h4><?php echo $nama; ?></h4>
   			

   		</td>
   		
   </tr>
    <tr>
   
   		 	<td>
   	<?php echo $alamat; ?>

   		</td>
  
   </tr>
</table>
<br>
 <table class="t01" cellspacing="0" cellpadding="5px">    
 <thead>    
 <tr>
 	<th width="50">ID</th>
 	    <th >No SPB</th>
 	       <th>Asal</th>
 	       <th>Tujuan</th>
           <th>Jumlah</th>
           <th>Harga Satuan (Rp)</th>
           <th width="100">Total (Rp)</th>

 </tr>
</thead>
 <tbody>
     <?php $total_berat=0; $i=1; foreach ($barang as $val) {
        # code...
        $total_berat = $total_berat + $val->berat;
      ?>
     
      	<tr>
      		<td><?php echo $i; ?></td>
      		<td><?php echo $val->id_transaksi; ?></td>
          <td><?php echo $asal; ?></td>
          <td><?php echo $tujuan; ?></td>
          <td><?php echo $val->jumlah_coli.' - '.$val->opsi_satuan; ?></td>
        <td><?php echo number_format($val->harga_satuan, 0, ".", "."); ?></td>
        <td class="hb"><?php echo number_format($val->total_harga_satuan, 0, ".", "."); ?></td>
      	</tr>

    
       
      <?php 
       $i++;
  }
  ?>
    </tbody>
<tfoot class="tf01">
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><b>Sub Total</b></td>
		<td class="tdfoot"><b><?php echo number_format($total_harga, 0, ".", "."); ?></b></td>

	</tr><tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>Biaya Packing</td>
	<td class="tdfoot"><?php echo number_format($total_harga_packing, 0, ".", "."); ?></td>

	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>Biaya Asuransi</td>
		<td class="tdfoot"><?php echo number_format($total_harga_asuransi, 0, ".", "."); ?></td>

	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><b>Total</b></td>
		<td class="tdfoot"><b><?php echo number_format($total_harga_global, 0, ".", "."); ?></b></td>

	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td>Pajak +</td>
		<td class="tdfoot"><?php echo number_format($pajak, 0, ".", "."); ?></td>

	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td><b>Total Tagihan</b></td>
		<td class="tdfoot"><b><?php echo number_format($total, 0, ".", "."); ?></b></td>

	</tr>
</tfoot>
    
</table>
<br>
 <table style="text-align: left;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px">        
   
    <tr>
    	 <td  style="background-color:#939394;color: #ffffff;font-weight: bold;">
       Catatan
        </td>
       
    </tr>
      <tr>
    	 <td style="border: 1px solid #333333;">
    Mohon segera diTransfer Ke : Bank BNI, Name : iP LOGISTINDO, Acc : 1777 00 1117
<br>"Kami Ucapkan TERIMA KASIH atas pembayaran yang tepat waktu"
        </td>
       
    </tr> 
 </table>
		<br><br><br>
		     <table style="text-align: center;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px" border="0">        
    <tr>
        <td width="70%">
        </td>
        <td class="inv">

Medan <?php echo date('d M Y')?><br>
<br><br><br>Matrai
<br><br><br><br>Finance
</div>
        </td>
       
       
    </tr>  
   
</table>
    </body>
</html>




