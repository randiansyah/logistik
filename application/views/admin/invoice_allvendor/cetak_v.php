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
  font-size: 22px;
  color:#d35400;
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
        	Komp.Medan Resort City No.19<br>
        	Jl. Merci Raya - Medan Johor<br>
        	Sumatera Utara
        </td>
        <td class="inv"><div class="atur-margin"></div><b><h3>PAYMENT REQUEST</h3>
Invoice No. <?php echo $inv?><br>
Tanggal Pengajuan  : <?php echo $tgl_pengajuan; ?><br>
Jatuh Tempo      : <?php echo $tgl_jatuh_tempo?>
</div>
        </td>
       
       
    </tr>  
   
</table>
<br>
 <table style="text-align: left;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px">        
   
    <tr>
    	<td  style="background-color: #d35400;color: #ffffff;font-weight: bold;">
          Dibayar Kepada
        </td>
       
    </tr> 
   <tr>
   	<td>
   			<h4>VENDOR : <?php echo $nama; ?></h4>
   			

   		</td>
   		
   </tr>
   
</table>
<br>
 <table class="t01" cellspacing="0" cellpadding="5px">    
 <thead>    
 <tr>
 	<th width="20">ID</th>
  <th>Tanggal</th>
 	    <th >No PR</th>
 	       <th>Jumlah Coli</th>
 	       <th>Jumlah Kg</th>
          <th width="100">Total(Rp)</th>

 </tr>


</thead>
 <tbody>
     <?php $i=1; foreach ($spb as $val) {
  
      ?>
     
      	<tr>
      		<td><?php echo $i; ?></td>
          <td><?php echo  date("d M Y", strtotime($val->tanggal)); ?></td>
      		<td><?php echo $val->SPB; ?></td>
         <td><?php echo $val->jumlah_coli;  ?></td>
          <td><?php echo $val->berat;  ?></td>
        <td class="hb"><?php echo "Rp ".number_format($val->total_harga_satuan, 0, ".", "."); ?></td>
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
      


    <td><b>Total Tagihan</b></td>
    <td class="tdfoot"><b><?php echo "Rp ".number_format($sub_total, 0, ".", "."); ?></b></td>

  </tr>
 
    
   

</tfoot>
    
</table>
  <br><br><br>
         <table style="text-align: center;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px" border="0">        
    <tr>
        <td width="70%">
        </td>
        <td class="inv">

Diajukan Oleh<br>
<br><br><br>
<br><br><br><br>Finance
</div>
        </td>
       
       
    </tr>  
   
</table>
    </body>
</html>




