define([
    "jQuery",
    "jQueryUI",
    "bootstrap", 
    "highchart",
    "sidebar",
    "bootstrapDatepicker",
    "bootstrapDaterangepicker",
    "datatables",
    "select2",
    "datatablesBootstrap",
    "moment",
    ], function (
    $,
    jQueryUI,
    bootstrap, 
    highchart,
    sidebar ,
    datatables,
    datatablesBootstrap,
bootstrapDatepicker, 
bootstrapDaterangepicker,
moment,
    ) {
    return {  
        table:null,
       
        kdkab_asal:$("#kdkab_asal_selected").val(),
       kdkab_tujuan:$("#kdkab_tujuan_selected").val(),
       kdprop_tujuan:$("#kdprop_tujuan_selected").val(),
        
        init: function () { 
            App.initFunc();
            App.initEvent(); 
            App.initTable(); 
             App.locPicker();  
            App.initConfirm();
            $(".loading").hide();
        }, 
        initTable : function(){  

              $('.select2').select2();
         $('input.form-control.datetime').daterangepicker({
            timePicker: false,
            timePickerIncrement: 10,
            singleDatePicker: true,

             locale: {
      format: 'Y-MM-DD'
    }
        });
                var suburl = $('#suburl').val();
            App.table = $('#table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": App.baseUrl+suburl+"/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "id_transaksi" },
                 { "data": "pickup" },
                    { "data": "nama" },
                    
                    { "data": "kirim_via" },
                    { "data": "asal" },
                    { "data": "tujuan" },
                    { "data": "jadwal_pickup" },
                    { "data": "status" },
                    { "data": "action" },                    
                ],
                 "order": [[0, 'desc']]      
            });

          $("#pelanggan").select2({
                placeholder: "Pilih Customer",
            });

            $("#kdprop").select2({
                placeholder: "Pilih Provinsi",
            });
             $("#kdprop_tujuan").select2({
                placeholder: "Pilih Provinsi",
            });
               $("#kdkab").select2({
                placeholder: "Pilih Kota/Kabupaten",
            });
                $("#kdkab_tujuan").select2({
                placeholder: "Pilih Kota/Kabupaten",
            });
                $("#opsi_satuan").select2({
                placeholder: "Pilih Satuan",
            });
                $("#vendor").select2({
                placeholder: "Pilih vendor",
            });
        
        },
         initEvent : function(){  
               
          

              $('.optionnya').on('change',function(){
                var id          = $(this).attr("id-tr");
                var e = $("input[name='opsi_satuan[]']").eq(id).val();
                $("input[name='getOption[]'").eq(id).val(this.value);     
            });
             $('.optionnya').trigger("onchange"); 

             $('.harga_asuransi').keyup(function(){
                var id          = $(this).attr("id-tr");
                var harga_asuransi = $("input[name='harga_asuransi[]']").eq(id).val();
                var harga_asuransi1 = harga_asuransi.replace(/\D/g, '');
           
        $("input[name='total_harga_asuransi[]']").eq(id).val(harga_asuransi);
      $("input[name='total_harga_asuransi_convert[]']").eq(id).val(harga_asuransi1);
                    

            });
             $('.harga_asuransi').trigger("keyup"); 

                $('.harga_packing').keyup(function(){
                var id          = $(this).attr("id-tr");
                var jumlah_packing = $("input[name='jumlah_packing[]']").eq(id).val();
                var harga_packing = $("input[name='harga_packing[]']").eq(id).val();
                var harga_packing = harga_packing.replace(/\D/g, '');
                total_harga_packing = harga_packing * jumlah_packing;
             jml_packing_convert = convertToRupiah(total_harga_packing);
             harga_packing_rupiah = convertToRupiah(harga_packing);
            $("input[name='harga_packing[]']").eq(id).val(harga_packing_rupiah);
             $("input[name='total_harga_packing[]']").eq(id).val(jml_packing_convert);
            $("input[name='total_harga_packing_convert[]']").eq(id).val(total_harga_packing);
                     


            });
             $('.harga_packing').trigger("keyup"); 

              $('.jumlah_packing').keyup(function(){

                var id          = $(this).attr("id-tr");
                var jumlah_packing = $("input[name='jumlah_packing[]']").eq(id).val();
                var harga_packing = $("input[name='harga_packing[]']").eq(id).val();
                var harga_packing = harga_packing.replace(/\D/g, '');
                total_harga_packing = harga_packing * jumlah_packing;
             jml_packing_convert = convertToRupiah(total_harga_packing);
             harga_packing_rupiah = convertToRupiah(harga_packing);
            $("input[name='harga_packing[]']").eq(id).val(harga_packing_rupiah);
             $("input[name='total_harga_packing[]']").eq(id).val(jml_packing_convert);
            $("input[name='total_harga_packing_convert[]']").eq(id).val(total_harga_packing);
                   



            });
             $('.jumlah_packing').trigger("keyup");

            $('.harga_satuan').keyup(function(){
                var id          = $(this).attr("id-tr");
                var jumlah         = $("input[name='jumlah[]']").eq(id).val();
                var harga_satuan       = $("input[name='harga_satuan[]']").eq(id).val();
                var harga_satuan = harga_satuan.replace(/\D/g, '');
                   total_harga_satuan = jumlah * harga_satuan;

             satuan_convert = convertToRupiah(total_harga_satuan);
             $("input[name='total_harga_satuan[]']").eq(id).val(satuan_convert);
             $("input[name='total_harga_satuan_convert[]']").eq(id).val(total_harga_satuan);
                     
            });
             $('.harga_satuan').trigger("keyup"); 

              $('.jumlah').keyup(function(){
                var id          = $(this).attr("id-tr");

                var jumlah         = $("input[name='jumlah[]']").eq(id).val();
                var harga_satuan       = $("input[name='harga_satuan[]']").eq(id).val();
                var harga_satuan = harga_satuan.replace(/\D/g, '');
                   total_harga_satuan = jumlah * harga_satuan;

             satuan_convert = convertToRupiah(total_harga_satuan);
             $("input[name='total_harga_satuan[]']").eq(id).val(satuan_convert);
             $("input[name='total_harga_satuan_convert[]']").eq(id).val(total_harga_satuan);
                     
            });
             $('.jumlah').trigger("keyup");

               $('.total_harga_satuan').keyup(function(){

              var id          = $(this).attr("id-tr");
              var total_harga_satuan = $("input[name='total_harga_satuan[]']").eq(id).val();
              var total_harga_satuan = total_harga_satuan.replace(/\D/g, '');
              $("input[name='total_harga_satuan_convert[]']").eq(id).val(total_harga_satuan);


          
            });
             $('.total_harga_satuan').trigger("keyup"); 
         
             $('.total_harga_packing').keyup(function(){

              var id          = $(this).attr("id-tr");
              var total_harga_packing = $("input[name='total_harga_packing[]']").eq(id).val();
              var total_harga_packing = total_harga_packing.replace(/\D/g, '');
              $("input[name='total_harga_packing_convert[]']").eq(id).val(total_harga_packing);
            });
             $('.total_harga_packing').trigger("keyup");

               $('.pajak').keyup(function(){

             
              var pajak = $("input[name='pajak']").val();
              var pajak = pajak.replace(/\D/g, '');
              $("input[name='pajak_convert']").val(pajak);
            });
             $('.pajak').trigger("keyup");

             $('.total_harga_asuransi').keyup(function(){

              var id          = $(this).attr("id-tr");
              var total_harga_asuransi = $("input[name='total_harga_asuransi[]']").eq(id).val();
              var total_harga_asuransi = total_harga_asuransi.replace(/\D/g, '');
              $("input[name='total_harga_asuransi_convert[]']").eq(id).val(total_harga_asuransi);
            });
             $('.total_harga_asuransi').trigger("keyup"); 

               $('#hitung').on('click', function () { 

               var no = $("input[name='no[]']");
               for(var i=0;i<no.length;i++){
                //jumlah coli
              var jumlah_coli = $("input[name='jumlah_coli[]']").eq(i).val();
              $("input[name='jumlah_packing[]']").eq(i).val(jumlah_coli);
              //packing
              var packing = $("input[name='packing[]']").eq(i).val();
               var panjang = $("input[name='panjang[]']").eq(i).val();
                var lebar = $("input[name='lebar[]']").eq(i).val();
                var tinggi = $("input[name='tinggi[]']").eq(i).val();
                //rumus packing kayu
                if(packing == 1){
              harga_packing  = (parseInt(panjang) + parseInt(tinggi) + parseInt(lebar))/3 * 3000;
                }else{
              harga_packing = "0";
                }
        harga_packing_rupiah = convertToRupiah(harga_packing);
        $("input[name='harga_packing[]']").eq(i).val(harga_packing_rupiah);
       total_harga_packing = harga_packing * jumlah_coli;
        jml_packing_convert = convertToRupiah(total_harga_packing);
       $("input[name='total_harga_packing[]']").eq(i).val(jml_packing_convert);
       $("input[name='total_harga_packing_convert[]']").eq(i).val(total_harga_packing);
         
         //asuransi
          var asuransi =  $("input[name='asuransi[]']").eq(i).val();
          var harga_barang =  $("input[name='harga_barang[]']").eq(i).val();
               if(asuransi == 1){
              var rumus = harga_barang * 0.3/100;
               }else{
               var rumus = "0";
               }

              harga_asuransi = convertToRupiah(rumus);
             $("input[name='harga_asuransi[]']").eq(i).val(harga_asuransi);
             $("input[name='total_harga_asuransi[]']").eq(i).val(harga_asuransi);
             $("input[name='total_harga_asuransi_convert[]']").eq(i).val(rumus);

             //volume
                var s = document.getElementById('kirim_via');
                var kirim_via = s.options[s.selectedIndex].value;

              

                   if(kirim_via == "Darat" ){
                var rumus = (parseInt(panjang) * parseInt(tinggi) * parseInt(lebar))/4000;
                var rumus_v = Math.round(rumus);
               
                }else if(kirim_via == "Udara"){
                   var rumus = (parseInt(panjang) * parseInt(tinggi) * parseInt(lebar))/6000;
                   var rumus_v = Math.round(rumus);
                }else{
                    var rumus = (parseInt(panjang) * parseInt(tinggi) * parseInt(lebar))/4000;
                var rumus_v = Math.round(rumus);
                }
             

                $("input[name='jumlah[]']").eq(i).val(rumus_v);

         } 
               });
               //reset data
                   $('#resetData').on('click', function () {
                  //  alert("sukses");
                     $("input[name='jumlah_packing[]']").val("");
                     $("input[name='harga_packing[]']").val("");
                     $("input[name='harga_asuransi[]']").val("");
                     $("input[name='total_harga_packing[]']").val("");
                     $("input[name='total_harga_asuransi[]']").val("");
                     $("input[name='jumlah[]']").val("");
                    $("input[name='harga_satuan[]']").val("");
                    $("input[name='total_harga_satuan[]']").val("");
                   });

            $('#hitung_total').on('click', function () {    
            var satuan = document.getElementsByName('total_harga_satuan_convert[]');
            var packing = document.getElementsByName('total_harga_packing_convert[]');
            var asuransi = document.getElementsByName('total_harga_asuransi_convert[]');
            var pajak = $("input[name='pajak_convert']").val();
            
    var total_satuan=0;
    var total_packing=0;
    var total_asuransi=0;

    for(var i=0;i<satuan.length;i++){
        if(parseInt(satuan[i].value))
            total_satuan += parseInt(satuan[i].value);
    }
     for(var i=0;i<packing.length;i++){
        if(parseInt(packing[i].value))
            total_packing += parseInt(packing[i].value);
    }
    for(var i=0;i<asuransi.length;i++){
        if(parseInt(asuransi[i].value))
            total_asuransi += parseInt(asuransi[i].value);
    }
    total_harga_global = total_satuan + total_packing + total_asuransi + parseInt(pajak);
    t_total = total_satuan + parseInt(pajak);
   total_s = convertToRupiah(total_satuan);
   total_p = convertToRupiah(total_packing);
   total_a = convertToRupiah(total_asuransi);
   total_g = convertToRupiah(total_harga_global);
   total_t = convertToRupiah(t_total);

    document.getElementById('total_harga').value = total_s;
    document.getElementById('total_harga_global').value = total_g;
    document.getElementById('sum_harga_packing').value = total_p;
    document.getElementById('sum_harga_asuransi').value = total_a;
var total = $("input[name='total']").val(total_t);

            });
            
        
       function convertToRupiah(angka)
       {
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
       }
  
            $("#kirim_via").select2({
                placeholder: "Pilih Salah Satu",
            });
            
            $("#jenis_pengiriman").select2({
                placeholder: "PilihPilih Salah Satu",
            });
            
            $("#jenis_pembayaran").select2({
                placeholder: "Pilih Salah Satu",
            });
            
            

        },
              locPicker:function(){


            $('#kdprop').on('change',function(){
                $.ajax({
                    url: App.baseUrl+'wilayah/get_kabupaten',
                    type: 'GET',
                    data: {
                        kdprop:$('#kdprop').val()
                    },
                    beforeSend:function(){
                        $('#kdkab').prop('disabled',true);
                        $('#kdkec').prop('disabled',true);
                        $('#kddesa').prop('disabled',true);
                    },
                    success:function(r){
                        var r = JSON.parse(r);
                        var element = '<option value="" selected>Semua Kab/ Kota</option>';
                        var data = r.data;

                        for (var i = 0; i < data.length; i++) {
                            if(App.kdkab_asal !== undefined && App.kdkab_asal == data[i].kdkab){
                                element+='<option value="'+data[i].kdkab+'" selected>'+data[i].nmkab+'</option>';

                            }else{
                                element+='<option value="'+data[i].kdkab+'">'+data[i].nmkab+'</option>';
                            }
                        }

                        $('#kdkab').html(element);
                       $('#kdkab').trigger("change");
                        $('#prop').val($('#kdprop option:selected').text());
                        $('#kdkec').html('<option value="" selected>Semua Kecamatan</option>');
                        $('#kddesa').html('<option value="" selected>Semua Kelurahan</option>');
                        $('#kdkab').prop('disabled',false);
                        $('#kdkec').prop('disabled',false);
                        $('#kddesa').prop('disabled',false);
                       
                    }
                });
            });
       
         $('#kdprop').trigger("change");
        
         
           
             $('#kdprop_tujuan').on('change',function(){
                $.ajax({
                    url: App.baseUrl+'wilayah/get_kabupaten',
                    type: 'GET',
                    data: {
                        kdprop:$('#kdprop_tujuan').val()
                    },
                    beforeSend:function(){
                        $('#kdkab_tujuan').prop('disabled',true);
                      
                    },
                    success:function(r){
                        var r = JSON.parse(r);
                        var element = '<option value="" selected>Semua Kab/ Kota</option>';
                        var data = r.data;

                        for (var i = 0; i < data.length; i++) {
                            if(App.kdkab_tujuan !== undefined && App.kdkab_tujuan == data[i].kdkab){
                                element+='<option value="'+data[i].kdkab+'" selected>'+data[i].nmkab+'</option>';

                            }else{
                                element+='<option value="'+data[i].kdkab+'">'+data[i].nmkab+'</option>';
                            }
                        }

                        $('#kdkab_tujuan').html(element);
                        $('#kdkab_tujuan').trigger("change");
                        $('#prop').val($('#kdprop_tujuan option:selected').text());
                        
                        $('#kdkab_tujuan').prop('disabled',false);
                        $('#kdkec').prop('disabled',false);
                        $('#kddesa').prop('disabled',false);

                    }
                });
            });
             var kdprop_tujuan = $("#kdprop_tujuan").val();
            $('#kdprop_tujuan').trigger("change");
         


        },
          
            
         searchTable:function(){ 
            $('#search').on('click', function () {
                console.log("SEARCH");
                var nama   = $("#nama").val();
                App.table.column(1).search(nama,true,true);
                App.table.draw();
                
            }); 
        },
        resetSearch:function(){
            $('#reset').on( 'click', function () { 
              
            
            });
          
        },  
        initConfirm :function(){
            
                $('#spbDelete').on( 'click', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah anda yakin ingin menghapus barang rincian?",function(){
                   $.ajax({
                      method: "GET",
                      url: url
                    }).done(function( msg ) {
                        location.reload(null,true);
                    });        
                })
            });
            
            $('#table tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah anda yakin ingin menghapus data ini?",function(){
                   $.ajax({
                      method: "GET",
                      url: url
                    }).done(function( msg ) {
                        App.table.ajax.reload(null,true);
                    });        
                })
            });
        }
    
    }
});