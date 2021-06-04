define([
    "jQuery",
    "jQueryUI",
    "bootstrap", 
    "highchart",
    "sidebar",
    "datatables",
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
                    "url": App.baseUrl+"menu/dataList",
                    "dataType": "json",
                    "type": "POST",
                }, 
                   
                "columns": [
                    { "data": "id","orderable": false},
                    { "data": "id_menu" },
                    { "data": "id_cabang","orderable": false },
                    { "data": "nama_menu","orderable": false },
                    { "data": "label_menu","orderable": false},
                    { "data": "kelas_menu","orderable": false},
                    { "data": "kategori_menu","orderable": false},
                    { "data": "tipe_menu","orderable": false },
                    { "data": "satuan" ,"orderable": false},
                    { "data": "harga_jual" },
                    { "data": "action" ,"orderable": false}        
                ]      
            }); 
            
        },

        searchTable:function(){ 
            $('#search').click(function(event) {

                nama  = $("#nama").val();
                kat   = $("#kat").val();
                cabang   = $("#cabang").val();

                App.table.column(1).search(cabang,true,true);
                App.table.column(2).search(kat,true,true);
                App.table.column(3).search(nama,true,true);
                App.table.draw();
            });
        },

        resetSearch:function(){
            $('#reset').on( 'click', function () {
                $("#nama").val("");
                $("#kat").val("");
                $("#cabang").val("");

                App.table.search( '' ).columns().search( '' ).draw();
            });
        },

        initConfirm :function(){
            $('#table tbody').on( 'click', '.delete', function () {
                var url = $(this).attr("url");
                App.confirm("Hapus Data?",function(){
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