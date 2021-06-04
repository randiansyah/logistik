define([
    "jQuery",
    "jQueryUI",
    "bootstrap", 
    "highchart",
    "sidebar",
    "bootstrapDatepicker",
    "datatables",
    "select2",
    "jqvalidate",
    "datatablesBootstrap",
    ], function (
    $,
    jQueryUI,
    bootstrap, 
    highchart,
    sidebar ,
    jqvalidate,
    select2,
    datatables,
    datatablesBootstrap
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
            App.searchTable();
            App.resetSearch(); 
            App.initConfirm();
            App.searchWilayah();
            $(".loading").hide();
        }, 
        initTable : function(){  
              $('.select2').select2();
              $('.datepicker').datepicker({
                defaultViewDate: '01/01/2019',
                uiLibrary: 'bootstrap4',
                format: 'dd/mm/yyyy',
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
                    { "data": "nama" },
                    { "data": "telp" },
                    { "data": "kirim_via" },
                    { "data": "asal" },
                    { "data": "tujuan" },
                    { "data": "posting" },
                    { "data": "status" },

                   
                   
                ],
               "order": [[0, 'desc']]          
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
                placeholder: "Pilih ",
            });
           $('#konfirmasi').prop('disabled',true);
        
        },
         initEvent : function(){
            $("#form").validate({ 
                rules: {
                    item: {
                        required: true
                    }
                }              
            });

            
            $("#jenis_pengiriman").select2({
                placeholder: "PilihPilih Salah Satu",
            });
            
            $("#jenis_pembayaran").select2({
                placeholder: "Pilih Salah Satu",
            });
            
            

        },
              locPicker:function(){
  

    var counter = 1;
    var nomor = 1;
    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";
        cols += '<td><input type="text" id="no" id-tr="'+ counter +'" value="'+ counter +'" class="form-control" name="no[' + counter + ']"/></td>';
        cols += '<td><input type="text" value="0" placeholder="Jenis Barang" class="form-control" name="jenis_barang[' + counter + ']"/><br><label>Panjang /cm</label><input type="text" placeholder="Panjang" value="0" class="form-control" name="panjang[' + counter + ']"/></td>';
        cols += '<td><input type="text" value="0" placeholder="Harga Barang" class="form-control harga" name="harga_barang[' + counter + ']"/><br><label>Lebar /cm</label><input type="text" placeholder="Lebar" value="0" class="form-control" name="lebar[' + counter + ']"/></td>';
        cols += '<td><input type="text" value="0" placeholder="Coli" class="form-control"  name="total_coli[' + counter + ']"/><br><label>Tinggi /cm</label><input type="text" class="form-control" placeholder="Tinggi" value="0" name="tinggi[' + counter + ']"/></td>';
        cols += '<td><input type="text" value="0" placeholder="Berat" class="form-control" id="berat"  name="berat[' + counter + ']"/><br><label>Total /Kg</label><input type="text" class="form-control" placeholder="Total" value="0" name="berat_total[' + counter + ']"/></td>';
        cols += '<td><div class="checkbox" style="margin-top:4px;"><label><input type="checkbox" value="1" name="packing[' + counter + ']" id="packing">Packing</label></div><div class="checkbox" value="0" style="margin-top:19px;"><label><input type="checkbox" value="1" name="asuransi[' + counter + ']" id="asuransi">Asuransi</label></div></td>';
        cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Hapus"></td>';
             
        newRow.append(cols);
        $("table.table-hover").append(newRow);
        counter++;

    });

    $("table.table-hover").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();       
        counter -= 1
    });

  $('#cekSPB').on('click',function(){
              var nomor = $("input[name='id_transaksi']").val();
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
                        $('#dangerSPB').html("ID TRANSAKSI ADA! HUBUNGI ADMIN");
                        $('#konfirmasi').prop('disabled',true);
                        $('#suksesSPB').html("");
                       }else{
                        //jika tidak
                        $('#suksesSPB').html("SUKSES! ID TRANSAKSI BELUM ADA");
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
          
        searchWilayah: function(){
            $("select.selectKota").select2({
                dropdownCssClass: "select-form--address",
                minimumInputLength: 3,
                placeholder: 'Cari Nama kota/kecamatan',
                ajax: {
                    dataType: 'json',
                    url: App.baseUrl+'Pesanan/getAllKotaKab',
                    delay: 800,
                    data: function(params) {
                        return {
                          search: params.term
                        }
                    },
                    processResults: function (data, page) {

                        return {
                            results: data,
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function (evt) {
                
                var data = $(".selectKota option:selected").text();
                $("#kdkota").val(data);
                $('select.selectKota').trigger("change");
            });

            $("select.selecttujuan").select2({
                dropdownCssClass: "select-form--tujuan",
                minimumInputLength: 3,
                placeholder: 'Cari Nama kota/kecamatan',
                ajax: {
                    dataType: 'json',
                    url: App.baseUrl+'Pesanan/getAllKotaKabTujuan',
                    delay: 800,
                    data: function(params) {
                        return {
                          search: params.term
                        }
                    },
                    processResults: function (data, page) {

                        return {
                            results: data,
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function (evt) {
                
                var data = $(".selecttujuan option:selected").text();
                $("#kdtujuan").val(data);
                $('select.selectTujuan').trigger("change");
            });
  
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