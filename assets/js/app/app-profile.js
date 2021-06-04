define([
    "jQuery",
    "jqvalidate",
    "bootstrap", 
    "bootstrapDatepicker",
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    ], function (
    $,
    jqvalidate,
    bootstrap,
    bootstrapDatepicker,
    sidebar,
    datatables,
    datatablesBootstrap
    ){ 
    return {
        table:null,
        init: function () {  
            App.initFunc();
            App.initEvent();
            App.initConfirm();
            App.searchTable();
            App.resetSearch(); 
            $(".loading").hide();
        },
        initEvent : function(){
            App.table = $('#table').DataTable({
                "language": {
                    "search": "Cari",
                    "lengthMenu": "Tampilkan _MENU_ baris per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data yang ditampilkan ",
                    "infoFiltered": "(pencarian dari _MAX_ total records)",
                    "paginate": {
                        "first":      "Pertama",
                        "last":       "Terakhir",
                        "next":       "Selanjutnya",
                        "previous":   "Sebelum"
                    },
                },
                "processing": true,
                "serverSide": true,
                "ajax":{
                    "url": App.baseUrl+"user/dataList",
                    "dataType": "json",
                    "type": "POST",
                    
                },
               "columns": [
                    { "data": "id" },  
                    { "data": "role_name" }, 
                    { "data": "name" },
                    { "data": "email" },
                     { "data": "password" },
                    { "data": "action" ,"orderable": false}
                ]      
            }); 
            
          
            
           

            $('#cekpas').click(function(event) {
              
           if($(this).is(':checked')){
                $('#new_password').attr('type','text');
                $('#confirm_password').attr('type','text');
            }else{
                $('#new_password').attr('type','password');
                $('#confirm_password').attr('type','password');
            }
        
            
            });
            

            if($("#form").length > 0){
                $("#form").validate({
                    rules: {
                        first_name: {
                            required: true,
                        },
                        email: {
                            required: true,
                        },
                       
                        role_id: {
                            required: true,
                        },
                         kode_karyawan: {
                            required: true,
                        },
                        password: {
                            required: ($("#id").val() === "")?true:false,
                        },
                        password_confirm: { 
                            required: ($("#id").val() === "")?true:false,
                            equalTo: '#password',
                        }
                    },
                    messages: {
                        first_name: {
                            required: 'Nama Lengkap Harus Diisi',
                        },
                        email: {
                            required: 'Email Harus Diisi',
                        },
                        kode_karyawan: {
                            required: 'kode karyawan Harus Diisi',
                        },
                        role_id: {
                            required: 'Jabatan Harus Diisi',
                        },
                        password: {
                            required: "Password Harus Diisi",
                        },
                        password_confirm: {
                            required: "Password Pencocokan Harus Diisi",
                            equalTo: "Password Tidak Sama",
                        }
                    }
                });
            }
        }, 
        
        searchTable:function(){ 
            $('#search').click(function(event) {

                jabatan     = $("#jabatan").val();
                first_name  = $("#first_name").val();
                status       = $("#status").val();

                App.table.column(1).search(jabatan,true,true);
                App.table.column(2).search(first_name,true,true);
                App.table.column(3).search(status,true,true);
                App.table.draw();
            });
        },

        resetSearch:function(){
            $('#reset').on( 'click', function () {
                $("#jabatan").val("");
                $("#first_name").val("");
                $("#status").val("");

                App.table.search( '' ).columns().search( '' ).draw();
            });
        },

        initConfirm :function(){
            $('#table tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                App.confirm("Apakah Anda Yakin Untuk Mengubah Ini?",function(){
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