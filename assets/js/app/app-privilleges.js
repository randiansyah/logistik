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
            $(".loading").hide();
        }, 
        initEvent : function(){  
            App.initDatatables();
         
            
            $("#checkAll").change(function () {  
                $("input:checkbox.cb-element").prop('checked', $(this).prop("checked"));
                $("input:checkbox.cb-element-child").prop('checked', $(this).prop("checked"));
            });
            $(".cb-element").change(function () { 
                
                App.checkAllCheckbox();
                $parent = $(this).closest( "tr" ).find(".cb-element-child"); 
                $parent.prop('checked', $(this).prop("checked"));
            });

            $(".cb-element-child").change(function () { 
                $parent = $(this).closest( "tr" ).find(".cb-element");
                $child = $(this).closest( "tr" ).find(".cb-element-child"); 
                $childChecked = $(this).closest( "tr" ).find(".cb-element-child:checked"); 

                _tot = $child.length                        
                _tot_checked = $childChecked.length;   
                if(_tot != _tot_checked){
                    $parent.prop('checked',false);
                }else{
                   $parent.prop('checked',true);
                }
                App.checkAllCheckbox();
            });
 
        },
        initDatatables :function(){
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
                    "url": App.baseUrl+"privileges/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" }, 
                    { "data": "role_name" }, 
                    { "data": "action" ,"orderable": false}
                ]      
            });
            
        },
  
        checkAllCheckbox:function(){
            _tot = $(".cb-element").length                        
            _tot_checked = $(".cb-element:checked").length;   
            if(_tot != _tot_checked){
                $("#checkAll").prop('checked',false);
            }else{
                $("#checkAll").prop('checked',true);
            }
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