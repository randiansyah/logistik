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
            App.initConfirm();

            $(".loading").hide();
        }, 
        initTable : function(){  

              $('.select2').select2();
         $('input.form-control.datetime').daterangepicker({
            timePicker: true,
            timePickerIncrement: 10,
            singleDatePicker: true,

             locale: {
      format: 'YYYY-MM-DD HH:mm:ss A'
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
                $("#nama_cs").select2({
                placeholder: "Pilih Kota/Kabupaten",
            });
                 $('#konfirmasi').prop('disabled',true);
        
        },
         initEvent : function(){  
               
            $('.berat').change(function(){
                var id          = $(this).attr("id-tr");
                var jumlah_coli         = $("input[name='jumlah_coli[]']").eq(id).val();
                var berat         = $("input[name='berat[]']").eq(id).val();
                $("input[name='berat_total[]']").eq(id).val(jumlah_coli * berat);
                     
            });
              $('.berat').trigger("keyup"); 

            $('.jumlah_coli').change(function(){
                var id          = $(this).attr("id-tr");
                var jumlah_coli         = $("input[name='jumlah_coli[]']").eq(id).val();
                var berat         = $("input[name='berat[]']").eq(id).val();
                $("input[name='berat_total[]']").eq(id).val(jumlah_coli * berat);
                     
            });
              $('.berat').trigger("keyup"); 


           

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

             $('#cekSPB').on('click',function(){
              var nomor = $("input[name='nomor']").val();
               var suburl = $('#suburl').val();
             // alert(noSPB);
             $.ajax({
                url: App.baseUrl+suburl+'/get_spb',
                type: 'GET',
                data : {nomor:nomor},

                success:function(r){
                     var r = JSON.parse(r);
                     var data = r.data;
                    //alert(data);
                    if(data !== null && data !== '') {
                        //jika double
                        $('#dangerSPB').html("No SPB Duplikat");
                        $('#konfirmasi').prop('disabled',true);
                        $('#suksesSPB').html("");
                       }else{
                        //jika tidak
                        $('#suksesSPB').html("SUKSES! No SPB belum ada");
                        $('#konfirmasi').prop('disabled',false);
                         $('#dangerSPB').html("");
                       }
                     
                }
             });
             });

             $('#cekSPBedit').on('click',function(){
             $('#konfirmasi').prop('disabled',false);
             });
             
           
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
                console.log("search");
                var nama_cs   = $("#nama_cs").val();
              
                var kode_delivery   = $("#kode_delivery").val();
                var jenis_pembayaran   = $("#jenis_pembayaran").val();
                var kirim_via   = $("#kirim_via").val();
                var kdprop  = $("#kdprop").val();
                var kdkab   = $("#kdkab").val();
                var kdprop_tujuan  = $("#kdprop_tujuan").val();
                var kdkab_tujuan   = $("#kdkab_tujuan").val();
                   // alert(kdprop);
                App.table.column(1).search(nama_cs,true,true);
                App.table.column(2).search(kode_delivery,true,true);
                App.table.column(3).search(jenis_pembayaran,true,true);
                App.table.column(4).search(kirim_via,true,true);
                App.table.column(5).search(kdprop,true,true);
                App.table.column(6).search(kdkab,true,true);
                App.table.column(7).search(kdprop_tujuan,true,true);
                App.table.column(8).search(kdkab_tujuan,true,true);
      
      
                App.table.draw();
                
            }); 
        },
        resetSearch:function(){
            $('#reset').on( 'click', function () { 
            $("#nama_cs").val("");
            $("#kode_delivery").val("");
             $("#jenis_pembayaran").val("");
              $("#kirim_via").val("");
        App.table.search( '' ).columns().search( '' ).draw();
            });
          
        },  
        initConfirm :function(){
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