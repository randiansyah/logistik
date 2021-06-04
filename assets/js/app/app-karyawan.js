define([
    "jQuery",
    "jQueryUI",
    "bootstrap", 
    "highchart",
    "sidebar",
    "bootstrapDatepicker",
    "datatables",
    "select2",
    "datatablesBootstrap",
    ], function (
    $,
    jQueryUI,
    bootstrap, 
    highchart,
    sidebar ,
    datatables,
    datatablesBootstrap
    ) {
    return {  
        table:null,
        init: function () { 
            App.initFunc();
            App.initEvent();   
            App.initConfirm();
            $(".loading").hide();
        }, 
        initEvent : function(){  
            
              $('.datepicker').datepicker({
                defaultViewDate: '01/01/2019',
                uiLibrary: 'bootstrap4',
                format: 'dd/mm/yyyy',
            });
            App.table = $('#table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": App.baseUrl+"karyawan/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" },
                    { "data": "KDPGW" },
                    { "data": "nama" },
                    { "data": "staff_level" },
                    { "data": "divisi" },
                    { "data": "status_karyawan" },
                    { "data": "no_hp" },
                    { "data": "action" ,"orderable": false}
                ]      
            });

            $("#KDCBG").select2({
                placeholder: "Please Salah Satu",
            });
            
            $("#agama").select2({
                placeholder: "Please Salah Satu",
            });
            
            $("#jenis_kelamin").select2({
                placeholder: "Please Salah Satu",
            });
            
            $("#golongan_darah").select2({
                placeholder: "Please Salah Satu",
            });
            
            $("#sim").select2({
                placeholder: "Please Salah Satu",
            });
            
            $("#pendidikan_terakhir").select2({
                placeholder: "Please Salah Satu",
            });
            
            $("#staff_level").select2({
                placeholder: "Please Salah Satu",
            });
            
            $("#divisi").select2({
                placeholder: "Please Salah Satu",
            });
            
            $("#status_karyawan").select2({
                placeholder: "Please Salah Satu",
            });

            if($("#karyawan").length > 0){
                $("#karyawan").validate({
                    rules: {
                        nama: {
                            required: true,
                        },
                        nickname: {
                            required: true,
                        }
                    },
                    messages: {
                        nama: {
                            required: 'Nama Lengkap Harus Diisi',
                        }
                    },
                     nickname: {
                            required: 'Nama Lengkap Harus Diisi',
                        }
                });
            } 
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
              
                /*
                $("#nama").val("");
                App.table.search( '' ).columns().search( '' ).draw();
                  */
            });
          
        },  
        initConfirm :function(){
            $('#table tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah anda yakin ingin mengubah data ini?",function(){
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