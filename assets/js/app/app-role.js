define([
    "jQuery",
    "jQueryUI",
    "bootstrap", 
    "sidebar",
    "datatables",
    "datatablesBootstrap",
    ], function (
    $,
    jQueryUI,
    bootstrap, 
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
                    "url": App.baseUrl+"role/dataList",
                    "dataType": "json",
                    "type": "POST",
                },
                "columns": [
                    { "data": "id" }, 
                    { "data": "name" },
                    { "data": "description" },
                    { "data": "action" ,"orderable": false}
                ]      
            });

            //append button to datatables
            add_btn = '<a href="'+App.baseUrl+'role/create" class="btn btn-sm btn-primary ml-2 mt-1"><i class="fa fa-plus"></i> Jabatan</a>';
            $('#table_filter').append(add_btn);

            if($("#form").length > 0){
                $("#save-btn").removeAttr("disabled");
                $("#form").validate({ 
                    rules: {
                        name: {
                            required: true
                        },
                        area_id: {
                            required: true
                        }, 
                        group_id: {
                            required: true
                        } 
                    },
                    messages: {
                        name: {
                            required: "Nama Role Harus Diisi"
                        },
                        area_id: {
                            required: "Area Harus Diisi"
                        }, 
                        group_id: {
                            required: "Grup Harus Diisi"
                        } 
                    }, 
                    debug:true,
                    
                    errorPlacement: function(error, element) {
                        var name = element.attr('name');
                        var errorSelector = '.form-control-feedback[for="' + name + '"]';
                        var $element = $(errorSelector);
                        if ($element.length) { 
                            $(errorSelector).html(error.html());
                        } else {
                            error.insertAfter(element);
                        }
                    },
                    submitHandler : function(form) { 
                        form.submit();
                    }
                }); 
            }


            var group_id_selected = $("#group_id_selected").val();
            $( "#area_id" ).change(function() {
                var area_id = $(this).val();
                $.ajax({
                  method: "GET",
                  url: App.baseUrl+"group/getGroupsByArea",
                  data: { area_id: area_id}
                })
                .done(function( msg ) {
                    var response = JSON.parse(msg);
                    var groups = response.data;
                    if(response.status){
                        var html = '<option  >Pilih Departemen</option>';
                        for (var i = 0; i < groups.length; i++) { 
                            if(group_id_selected == groups[i].id){
                                html += "<option value='"+groups[i].id+"' selected>"+groups[i].name+"</option>";
                            }else{
                                html += "<option value='"+groups[i].id+"'>"+groups[i].name+"</option>";    
                            } 
                        }

                        $("#group_id").html(html);
                    }
                   
                });
            });

            $( "#area_id" ).trigger('change');
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