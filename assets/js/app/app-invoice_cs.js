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
          App.searchTable();   
            App.resetSearch();
            $(".loading").hide();
        }, 
        initTable : function(){  

              $('.select2').select2();
         $('input.form-control.datetime').daterangepicker({
            timePicker: false,
            timePickerIncrement: 10,
            singleDatePicker: true,

             locale: {
      format: 'DD-MM-YYYY'
    }
        });
                var suburl = $('#suburl').val();
            App.table = $('#table').DataTable({
                "processing": true,
                "serverSide": true,
                 "bPaginate":   false,
                "ajax":{
                    "url": App.baseUrl+suburl+"/dataList",
                    "dataType": "json",
                    "type": "POST",
                     "data":function ( data ) {                  
                        data.periode_start = $('#periode_start').val();
                        data.periode_end= $('#periode_end').val();
                    }   
                      
                },
              
                "columns": [
                    { "data": "id" },
                    { "data": "nama" }, 
                    { "data": "jenis" },
                    { "data": "tanggal" },
                    { "data": "id_transaksi" },  
                    { "data": "asal" },
                    { "data": "tujuan" },
                    { "data": "kirim_via" },
                    { "data": "qty" },
                    { "data": "satuan" },    
                    { "data": "total_satuan" },  
                    { "data": "packing" },
                    { "data": "asuransi" },           
                    { "data": "cetak","orderable": false, },           
                  
                  
                ],
                 "order": [[1, 'desc']],

            });


             App.table1 = $('#table_manifest').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": App.baseUrl+suburl+"/dataList_manifest",
                    "dataType": "json",
                    "type": "POST",
                    
                      
                },
                "columns": [
                   { "data": "id" },
                    { "data": "id_transaksi" },
                      { "data": "tanggal" },
                    { "data": "vendor" },
                    { "data": "jenis_pembayaran" },
                  
                    { "data": "status" },
                    { "data": "action" },                      
                ],
                 "order": [[0, 'desc']],

            });


              $('#jumlah').on("click",function(){
            var coli = document.getElementsByName('coli[]');
            var kg = document.getElementsByName('kg[]');
          
            
    var total_satuan=0;
    var total_kg=0;


    for(var i=0;i<coli.length;i++){
        if(parseInt(coli[i].value))
            total_satuan += parseInt(coli[i].value);
    }
     
  for(var i=0;i<kg.length;i++){
        if(parseInt(kg[i].value))
            total_kg += parseInt(kg[i].value);
    }

    document.getElementById('jcoli').value = total_satuan;
document.getElementById('jkg').value = total_kg;
            });

              $('#jumlah').trigger("click"); 


          $("#vendor").select2({
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
        
        },
         initEvent : function(){  

                $('.harga_satuan').keyup(function(){
         
                var id          = $(this).attr("id-tr");
                var jumlah_coli         = $("input[name='coli[]']").eq(id).val();
                var getOption = $("input[name='getOption[]'").eq(id).val();
                var jumlah_kg         = $("input[name='kg[]']").eq(id).val();
                var harga_satuan       = $("input[name='harga_satuan[]']").eq(id).val();
                var harga_satuan = harga_satuan.replace(/\D/g, '');
               if(getOption == "kg"){
                  total_harga_satuan = jumlah_kg * harga_satuan;
                }else{
                   total_harga_satuan = jumlah_coli * harga_satuan;
                }
               
             packing_convert = convertToRupiah(total_harga_satuan);
             $("input[name='total_harga[]']").eq(id).val(packing_convert);
            $("input[name='total_harga_satuan_convert[]']").eq(id).val(total_harga_satuan);
                     
            });
             $('.harga_satuan').trigger("keyup"); 
          
              $('.optionnya').on('change',function(){
                var id          = $(this).attr("id-tr");
                var e = $("input[name='opsi_satuan[]']").eq(id).val();
                $("input[name='getOption[]'").eq(id).val(this.value);     
            });
             $('.optionnya').trigger("onchange");

             $('.pajak').keyup(function(){
             
              var pajak = $("input[name='pajak']").val();
              var pajak = pajak.replace(/\D/g, '');
              $("input[name='pajak_convert']").val(pajak);
            });
             $('.pajak').trigger("keyup");

              $('.pajak').keyup(function(){

             
              var pajak = $("input[name='pajak']").val();
              var pajak = pajak.replace(/\D/g, '');
              $("input[name='pajak_convert']").val(pajak);
            });
             $('.pajak').trigger("keyup");

              $('.packing').keyup(function(){
              var packing = $("input[name='harga_packing']").val();
              var packing = packing.replace(/\D/g, '');
              $("input[name='harga_packing_convert']").val(packing);
            });
             $('.packing').trigger("keyup");

                $('.asuransi').keyup(function(){
              var asuransi = $("input[name='harga_asuransi']").val();
              var asuransi = asuransi.replace(/\D/g, '');
              $("input[name='harga_asuransi_convert']").val(asuransi);
            });
             $('.asuransi').trigger("keyup");



             $('#hitung_total').on('click', function () {  
           //harga 
            var total = document.getElementsByName('total_harga_satuan_convert[]');
            var pajak = $("input[name='pajak_convert']").val();
            var packing = $("input[name='harga_packing_convert']").val();
            var asuransi = $("input[name='harga_asuransi_convert']").val();

            var total_harga=0;
            for(var i=0;i<total.length;i++){
            if(parseInt(total[i].value))
            total_harga += parseInt(total[i].value);
            }
            total_h = convertToRupiah(total_harga);
            document.getElementById('sub_total').value = total_h;
         ///plus pajak
          total = total_harga + parseInt(pajak);
          total_plus_pajak = convertToRupiah(total);
         document.getElementById('total').value = total_plus_pajak;

         //grand total
         g_total = total_harga + parseInt(pajak) + parseInt(packing) + parseInt(asuransi);
         g_total_all = convertToRupiah(g_total);
         document.getElementById('grand_total').value = g_total_all;


            });
            

           

            $("#kirim_via").select2({
                placeholder: "Pilih Salah Satu",
            });
            
            $("#jenis_pengiriman").select2({
                placeholder: "pilih Salah Satu",
            });
            
            $("#jenis_pembayaran").select2({
                placeholder: "Pilih Salah Satu",
            });
            
               function convertToRupiah(angka)
       {
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
       }

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
                var vendor   = $("#vendor").val();
                var periode_start = $("#periode_start").val();
                var periode_end = $("#periode_end").val();
                var jenis_pembayaran = $("#jenis_pembayaran").val();
                App.table.column(1).search(vendor,true,true);
                App.table.column(2).search(periode_start,true,true);
                App.table.column(3).search(periode_end,true,true);
                App.table.column(4).search(jenis_pembayaran,true,true);
                App.table.draw();
                
            }); 
                 $('#allcetak').on('click', function () {

                 if ($(this).is(':checked') ==  true)
    {

        $('.checkItem').prop('checked', true);
    }
    else
    {
        $('.checkItem').prop('checked', false);
    }
           
                
            }); 

        },
        resetSearch:function(){
            $('#reset').on( 'click', function () { 
                   $("#vendor").val("");
                $("#periode_start").val("");
                $("#periode_end").val("");
                 $("#jenis_pembayaran").val("");
  App.table.search( '' ).columns().search( '' ).draw();
            
            });
          
        },  
        initConfirm :function(){
            $('#table_manifest tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah anda yakin ingin menghapus data ini?",function(){
                   $.ajax({
                      method: "GET",
                      url: url
                    }).done(function( msg ) {
                        App.table1.ajax.reload(null,true);
                    });        
                })
            });
            $('#table_manifest tbody').on( 'click', '.selesai', function () {
                var url = $(this).attr("url");
                App.confirm("Konfirmasi Selesai ?",function(){
                   $.ajax({
                      method: "GET",
                      url: url
                    }).done(function( msg ) {
                        App.table1.ajax.reload(null,true);
                    });        
                })
            });
        }
    
    }
});