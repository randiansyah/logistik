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



 </style>
	</head>
	<body>
      <table style="text-align: left;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px" border="0">        
    <tr>
        <td width="66%"><br><br><br><br><br><br><img src="assets/images/logo1.png" width="90px" style="margin-top: 30px;">
        	<br>
        	<h4>iP LOGISTINDO</h4>
        	Komp.Medan Resort City No.19<br>
        	Jl. Merci Raya - Medan Johor<br>
        	Sumatera Utara
        </td>
        <td class="inv"><div class="atur-margin"></div><b><h3>MANIFEST</h3>
Manifest No. <?php echo $inv?><br>
Tanggal    : <?php echo date('d M Y'); ?><br>
Asal    : <?php echo $asal ?><br>
Vendor : <?php echo $nama?>
</div>
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
         <th>Service</th>
         <th>Coli</th>
         <th>Kg</th>
    

 </tr>


</thead>
 <tbody>
     <?php $i=1; foreach ($spb as $val) {
  
      ?>
     
      	<tr>
      		<td><?php echo $i; ?></td>
      		<td><?php echo $val->SPB; ?></td>
          <td><?php echo $val->asal; ?></td>
          <td><?php echo $val->tujuan; ?></td>
           <td><?php echo $val->service; ?></td>
         
              <td><?php echo $val->jumlah_coli; ?></td>
   <td class="hb"><?php echo $val->berat; ?></td>
       
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
        
         

    <td><b>Jumlah</b></td>
    <td class="tdfoot"><b><?php echo $koli; ?></b></td>
    <td class="tdfoot"><b><?php echo $berat_total; ?></b></td>
  </tr>
</tfoot>
    
</table>
<br>
<br>
<br>
<br>
 <table style=";width:100%;font-size:12px;" cellspacing="0" cellpadding="5px">        
   <tr>
      <td width="50%" style="text-align:left;">
       Keterangan :

        </td>
          <td width="50%" style="text-align:center;;">
      Dibuat Oleh
        </td>
   </tr>
    <tr>
   
        <td width="80%"  >

        </td>
          <td width="20%" style="text-align: center; margin-left:-20px;">
<br>
<br><br><br>
<br><br><br><br>Werehouse
</div>
        </td>
</tr>

   
 </table>
    </body>
</html>




