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
              <th>NAMA CS</th> 
            <th>[ KREDIT ] TAGIHAN</th> 
            <th>[ CASH ] TAGIHAN</th> 
             <th>[ TOTAL ] TAGIHAN</th>
             <th>JATUH TEMPO</th>  
                   <th class="bg-primary text-white">[ KREDIT ] TERTAGIH</th>
                 <th class="bg-primary text-white">[ CASH ] TERTAGIH</th>
    
                   <th class="bg-primary text-white">[ TOTAL ] TERTAGIH</th>
                 </tr>

              </thead> 
 <tbody>
<?php 
$total_kredit = 0;
$total_cash = 0;
$jatuh_tempo = 0;
$grand_total = 0;
$total_kredit_bayar = 0;
$total_cash_bayar = 0;
$total_bayar = 0;
 $i = 1; foreach ($data as $val) { 
  $total_kredit = $total_kredit + intval($val['total_kredit_jumlah']);
  $total_cash = $total_cash + intval($val['total_cash_jumlah']);
  $jatuh_tempo = $jatuh_tempo + intval($val['jatuh_tempo_jumlah']);
  $grand_total = $grand_total + intval($val['grand_total_jumlah']);
  $total_kredit_bayar = $total_kredit_bayar + intval($val['total_kredit_bayar_jumlah']);
  $total_cash_bayar = $total_cash_bayar + intval($val['total_cash_bayar_jumlah']);
  $total_bayar = $total_bayar + intval($val['total_bayar_jumlah']);
              ?>
    <tr>
    <td><?php echo $i; ?></td>
    <td><?php echo $val['nama']; ?></td>
    <td><?php echo $val['total_kredit']; ?></td>
    <td><?php echo $val['total_cash']; ?></td>
        <td><?php echo $val['grand_total']; ?></td>
    <td><?php echo $val['jatuh_tempo']; ?></td>

    <td><?php echo $val['total_kredit_bayar']; ?></td>
    <td><?php echo $val['total_cash_bayar']; ?></td>
    <td><?php echo $val['total_bayar']; ?></td>
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
    <td class="tdfoot"><?php echo "Rp ".number_format($total_kredit, 0, ".", "."); ?></td>
    <td class="tdfoot"><?php echo "Rp ".number_format($total_cash, 0, ".", "."); ?></td>
        <td class="tdfoot"><?php echo "Rp ".number_format($grand_total, 0, ".", "."); ?></td>

          <td class="tdfoot"><?php echo "Rp ".number_format($jatuh_tempo, 0, ".", "."); ?></td>
  
    <td class="tdfoot"><?php echo "Rp ".number_format($total_kredit_bayar, 0, ".", "."); ?></td>
    <td class="tdfoot"><?php echo "Rp ".number_format($total_cash_bayar, 0, ".", "."); ?></td>
    <td class="tdfoot"><?php echo "Rp ".number_format($total_bayar, 0, ".", "."); ?></td>


  </tr>
    
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




