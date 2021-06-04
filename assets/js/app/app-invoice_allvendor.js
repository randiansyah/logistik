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
      format: 'YYYY-MM-DD'
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
                    { "data": "tanggal" },
                    { "data": "id_transaksi" },  
                    { "data": "coli" },
                    { "data": "kg" },
                    { "data": "total" },
                  
                  
                ],
                 "order": [[0, 'desc']],

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
                    
                  
                    { "data": "total" },
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
                placeholder: "Pilih Vendor",
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

            

            $("#kirim_via").select2({
                placeholder: "Pilih Salah Satu",
            });
            
            $("#jenis_pengiriman").select2({
                placeholder: "pilih Salah Satu",
            });
            
            $("#jenis_pembayaran").select2({
                placeholder: "Pilih Salah Satu",
            });
         

        },
              locPicker:function(){

        },
          
            
         searchTable:function(){ 
            $('#search').on('click', function () {

                console.log("SEARCH");
                var vendor   = $("#vendor").val();
                 var periode_start = $("#periode_start").val();
                var periode_end = $("#periode_end").val();
                App.table.column(1).search(vendor,true,true);
                App.table.column(2).search(periode_start,true,true);
                App.table.column(3).search(periode_end,true,true);
                App.table.draw();
                
            }); 
        },
        resetSearch:function(){
            $('#reset').on( 'click', function () { 
                   $("#vendor").val("");
                $("#periode_start").val("");
                $("#periode_end").val("");
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