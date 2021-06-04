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
	font-size: 25px;
	color:#0d5ea2;
  text-align: left;
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
  font-weight: bold;
}
   header {
                position: fixed;
                top: -60px;
                left: 0px;
                right: 0px;
                height: 50px;

                /** Extra personal styles **/
                background-color: #ffffff;
                color: white;
                text-align: center;
                line-height: 35px;
            }

            footer {
                position: fixed; 
                bottom: -60px; 
                left: 0px; 
                right: 0px;
                height: 50px; 

                /** Extra personal styles **/
                background-color: #03a9f4;
                color: white;
                text-align: center;
                line-height: 35px;
            }


 </style>
	</head>
	<body>
     <header>
     
        </header>

        <footer>
            Copyright &copy; <?php echo date("Y");?> 
        </footer>
       <main>
      <table style="text-align: left;width:100%;font-size:12px;" cellspacing="0" cellpadding="5px" border="0">        
    <tr>
        <td width="70%"><br><br><br><br><br><br><img src="assets/images/logo3.png" width="130px" style="margin-top: 30px;">
          <br>
          <h4>iP Logistics</h4>
          Komp.Medan Resort City No.19<br>
          Jl. Merci Raya - Medan Johor<br>
          Sumatera Utara
        </td>
        <td class="inv"><div class="atur-margin"></div><b><h3>LAPORAN TRANSAKSI</h3>
Dari Tanggal : <?php echo date('d M Y',strtotime($periode_start));?><br>
Sampai Tanggal : <?php echo date('d M Y',strtotime($periode_end));?>
</div>
        </td>
       
       
    </tr>  
   
</table>
<br>
 <table class="t01" cellspacing="0" cellpadding="5px">    
 <thead>
  <tr>
              <th>#</th>
               <th width="">ID Invoice</th> 
                <th width="">Kode Delivery</th> 
                <th>Nama</th> 
            <th>Grand Total</th> 
            <th>Tgl Sekarang</th> 
             <th>Tgl Jatuh Tempo</th>
             <th>Status Pembayaran</th> 
</tr>
              </thead>  
 <tbody>
<?php 
$total_harga = 0;
 $i = 1; foreach ($data as $val) { 
  $total_harga = $total_harga + intval($val['total_harga_jumlah']);
              ?>
    <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $val['id_transaksi']; ?></td>
    <td><?php echo $val['pickup']; ?></td>
    <td><?php echo $val['nama']; ?></td>
    <td><?php echo $val['total_harga']; ?></td>
    <td><?php echo $val['tgl_sekarang']; ?></td>
    <td><?php echo $val['tgl_jatuh_tempo']; ?></td>
    <td><?php echo $val['status']; ?></td>
  

    </tr>
<?php
$i++;
 }
?>
    </tbody>
    <tfoot class="tf01">
  <tr>
    <td class="tdfoot"></td>
    <td class="tdfoot">Sub Total</td>
    <td class="tdfoot"></td>
    <td class="tdfoot"></td>
    <td class="tdfoot"><?php echo "Rp ".number_format($total_harga, 0, ".", "."); ?></td>
    <td class="tdfoot"></td>    <td class="tdfoot"></td>
    <td class="tdfoot"></td>
 

  </tr>
    </tfoot>
</table>

<br>

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
</main>
    </body>
</html>




