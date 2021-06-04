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
	margin-bottom: 1px;
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
td.tdfoot1{
  border-bottom:1px solid #333333;
  border-right:1px solid #333333;
  border-left:1px solid #333333;
  background-color: #939394;
  color: #ffffff;
}

td.tdfoot2{
  border-bottom:2px solid #939394;

}



 </style>
	</head>
	<body>
      <table style="text-align: left;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px" border="0">        
    <tr>
        <td width="66%"><br><br><br><br><br><br><img src="assets/images/logo3.png" width="130px" style="margin-top: 30px;">
        	<br>
        	<h4>iP Logistics</h4>
          Jl. Surau Gading, Kel. Rambah Samo,<br>
Kec. Rambah Samo, Kab. Rokan Hulu<br>
 Riau
        
        </td>
        <td class="inv"><div class="atur-margin"></div><b><h3>INVOICE</h3>
Invoice No. <?php echo $inv?><br>
Tanggal     : <?php echo date("d M Y"); ?><br>
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
 	<th width="20">ID</th>
  <th>Tanggal</th>
 	    <th >No SPB</th>
 	       <th>Asal</th>
 	       <th>Tujuan</th>
           <th>Service</th>
           <th colspan="2">Qty <br></th>
      
           <th>Harga</th>
        
           <th width="100">Jumlah(Rp)</th>

 </tr>


</thead>
 <tbody>
     <?php
   if(is_array($spb) && count($spb) > 0){
      $i=1; foreach ($spb as $val) {
  
      ?>
     
      	<tr>
      		<td><?php echo $i; ?></td>
          <td><?php echo  date("d M Y", strtotime($val->tanggal)); ?></td>
      		<td><?php echo $val->SPB; ?></td>
          <td><?php echo $val->asal; ?></td>
          <td><?php echo $val->tujuan; ?></td>
           <td><?php echo $val->service; ?></td>
          <td><?php echo $val->jumlah;  ?></td>
           <td>Kg</td>
        <td><?php echo "Rp ".number_format($val->harga_satuan, 0, ".", "."); ?></td>
        <td class="hb"><?php echo "Rp ".number_format($val->total_harga_satuan, 0, ".", "."); ?></td>
      	</tr>

    
       
      <?php 
       $i++;
  }
}else{
  echo "DATA KOSONG";
}
  ?>
    </tbody>
}
<tfoot class="tf01">

  <tr>
    <td></td>
      <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
      <td></td>
        <td></td>
      


    <td>Sub Total</td>
    <td class="tdfoot"><?php echo "Rp ".number_format($sub_total, 0, ".", "."); ?></td>

  </tr>
    <tr>
    <td></td>
      <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
      <td></td>
        <td></td>
      


    <td>Pajak(+)</td>
    <td class="tdfoot"><?php echo "Rp ".number_format($pajak, 0, ".", "."); ?></td>

  </tr>
      <tr>
   <td class="tdfoot2"></td> 
      <td class="tdfoot2"></td> 
  <td class="tdfoot2"></td> 
   <td class="tdfoot2"></td> 
    <td class="tdfoot2"></td> 
    <td class="tdfoot2"></td>
      <td class="tdfoot2"></td>
        <td class="tdfoot2"></td>
      


    <td class="tdfoot2">Total</td>
    <td class="tdfoot"><?php echo "Rp ".number_format($total, 0, ".", "."); ?></td>

  </tr>
    <tr>
    <td></td>
      <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
      <td></td>
        <td></td>
      


    <td>Packing</td>
    <td class="tdfoot"><?php echo "Rp ".number_format($packing, 0, ".", "."); ?></td>

  </tr>
    <tr>
    <td></td>
     <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
      <td></td>
        <td></td>
      


    <td>Asuransi</td>
    <td class="tdfoot"><?php echo "Rp ".number_format($asuransi, 0, ".", "."); ?></td>

  </tr>
    <tr>
    <td class="tdfoot2"></td> 
    <td class="tdfoot2"></td>
  <td class="tdfoot2"></td> 
   <td class="tdfoot2"></td> 
    <td class="tdfoot2"></td> 
    <td class="tdfoot2"></td>
      <td class="tdfoot2"></td>
        <td class="tdfoot2"></td>


    <td class="tdfoot2"><b>Grand Total</b></td>
    <td class="tdfoot1"><b><?php echo "Rp ".number_format($grand_total, 0, ".", "."); ?></b></td>

  </tr>
</tfoot>
    
</table>
<br>
 <table style="text-align: center;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px">        
   <tr>
      <td width="50%" style="background-color:#939394;color: #ffffff;font-weight: bold;">
       Catatan
        </td>
   </tr>
    <tr>
   
      <td width="50%"  style="border: 1px solid #333333;text-align: left;" >
   Mohon segera ditransfer ke :<br><br>

   Bank&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; <b>BNI</b><br>
   Name&nbsp;&nbsp;&nbsp;&nbsp;:&nbsp; <b>PT IRGA PRATAMA</b><br>
   No.Acc &nbsp;:&nbsp; <b>199 177 199 8</b><br><br>
   "Kami ucapkan TERIMA KASIH atas pembayaran yang tepat waktu"
        </td>

        <td width="50%" style="text-align: center; margin-left:-20px;">

Dibuat Oleh<br>
<br><br><br>
<br><br><br><br>Finance
</div>
        </td>
    </tr>
        <tr>
      <td width="50%" style="text-align:left">
       <?php echo $catatan; ?>
        </td>
   </tr>
</table>
    </body>
</html>




