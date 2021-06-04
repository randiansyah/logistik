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
          $('.datepicker').datepicker({
                uiLibrary: 'bootstrap4',
                format: 'dd-mm-yyyy',
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
                    { "data": "PR" },
                    { "data": "tanggal" },
                    { "data": "vendor" },
                    
                    { "data": "koli" },
                    { "data": "kg" },
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
               
              
            $('.harga_coli').keyup(function(){
                var id          = $(this).attr("id-tr");
                var harga_coli         = $("input[name='harga_coli[]']").eq(id).val();
                var jumlah_coli        = $("input[name='coli[]']").eq(id).val();
                var harga_coli = harga_coli.replace(/\D/g, '');
                total_harga_coli = jumlah_coli * harga_coli;
             
       $("input[name='total_harga_coli_convert[]']").eq(id).val(total_harga_coli); 
          
            });

             $('.harga_coli').trigger("keyup"); 
             $('.harga_kg').keyup(function(){
                var id          = $(this).attr("id-tr");
                var harga_kg         = $("input[name='harga_kg[]']").eq(id).val();
                var jumlah_kg        = $("input[name='kg[]']").eq(id).val();
                var harga_kg = harga_kg.replace(/\D/g, '');
                total_harga_kg = jumlah_kg * harga_kg;
             
       $("input[name='total_harga_kg_convert[]']").eq(id).val(total_harga_kg);    
            });

             $('.harga_kg').trigger("keyup"); 

              $('.total_harga').focus(function(){
  var id          = $(this).attr("id-tr");
  var coli = parseFloat($("input[name='total_harga_coli_convert[]']").eq(id).val());
  var kg  = parseFloat($("input[name='total_harga_kg_convert[]']").eq(id).val());
            total_harga = coli + kg;
             total_harga_convert = convertToRupiah(total_harga);           
       $("input[name='total_harga[]']").eq(id).val(total_harga_convert); 

            });


           $('#hitung_total').on('click', function () {  
           //coli 
            var coli = document.getElementsByName('total_harga_coli_convert[]');
            var total_coli=0;
            for(var i=0;i<coli.length;i++){
            if(parseInt(coli[i].value))
            total_coli += parseInt(coli[i].value);
            }
            total_c = convertToRupiah(total_coli);
            document.getElementById('total_harga_coli').value = total_c;
            //kg
            var kg = document.getElementsByName('total_harga_kg_convert[]');
            var total_kg=0;
            for(var i=0;i<kg.length;i++){
            if(parseInt(kg[i].value))
            total_kg += parseInt(kg[i].value);
            }
            total_k = convertToRupiah(total_kg);
            document.getElementById('total_harga_kg').value = total_k;
            //tagihan
            total_tagihan = total_coli + total_kg;
            var total_t = convertToRupiah(total_tagihan);
            document.getElementById('total').value = total_t;

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

                     var cabang = $("#id_transaksi").val();
    
                var periode_start = $("#tgl_rilis").val();
                var uri = '';   

             

               
                uri+= '?nomor='+nomor+'&periode_start='+periode_start;                

                // buat export csv
                var suburl = $('#suburl').val();
                var url = App.baseUrl+suburl+'/pdf'+uri;
                $('#pdf-tes').attr({href  : url});
                
            }); 
         

        },


        resetSearch:function(){
            $('#reset').on( 'click', function () { 
              
            
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
              $('#table tbody').on( 'click', '.selesai', function () {
                var url = $(this).attr("url");
                App.confirm("Konfirmasi Selesai ?",function(){
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