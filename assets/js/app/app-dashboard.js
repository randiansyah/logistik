define([
    "jQuery",
    "jQueryUI",
	  "bootstrap", 
    "highchart",
    "moment",
    "bootstrapDaterangepicker",
    "sidebar",
     "select2",
    "datatables",
    "datatablesBootstrap",
	], function (
    $,
    jQueryUI,
	bootstrap, 
    highchart,
    moment,
    bootstrapDaterangepicker,
    sidebar ,
    datatables,
    datatablesBootstrap
	) {
    return {  
        table:null,
        tableTransaksi:null,
        init: function () { 
        	App.initFunc(); 
        App.initEvent(); 
            App.initDatePicker(); 
            App.initSearchINV();
            App.initNewTable();
            //console.log("LOADED");
            
		}, 
        initNewTable : function(){
          var suburl = $('#suburl').val();
              var periode_start = $('#periode_start').val();
              var periode_end   = $('#periode_end').val();
              var pelanggan = $('#pelanggan').val();
             
            App.table = $('#table').DataTable({
                  language: {
                    paginate: {
                        next: false,
                        previous: false
                    }
                },
                  "pageLength": 3,
                "processing": true,
                "serverSide": true,
                "bLengthChange": false,
                "ajax":{
                    "url": App.baseUrl+suburl+"/daftarHarga",
                    "dataType": "json",
                    "type": "POST",
                    "data": function(data){
                           data.tujuan_darat = $('#tujuan_darat').val();
                           data.tujuan_laut = $('#tujuan_laut').val();
                           data.tujuan_udara = $('#tujuan_udara').val();
                           
                    }
                },
                "columns": [
                   { "data": "tujuan" },
                    { "data": "kg" },
                    { "data": "min" },
                    { "data": "coli_a" },
                    { "data": "coli_b" },
                    { "data": "coli_c" },
                    { "data": "lead_time" },
                    { "data": "keterangan" },


                   
                   
                ],
               "order": [[0, 'desc']]          
            });


        },
    initEvent : function(){ 
         $('.select2').select2();


                var options = {
                    chart: {
                        renderTo: 'per_hari',
                        defaultSeriesType: 'areaspline',
                       
                    },

credits:{enabled : false

},

                    title: {
                        text: false
                    },
                    xAxis: {
                      enabled: true,  
                    },
                    yAxis: {
                        title: {
                            enabled: false,
                        },
                 
                        labels: {
                            formatter: function () {
                                return Highcharts.numberFormat(this.value,0);
                            }
                        }
                    },
    
                    plotOptions: {
                        areaspline: {
                            fillOpacity: 0.5,
                        }
                    },
    
                    series: [{
                        showInLegend:false,
                       
                    }]
                };
                
              var periode_start = $('#periode_start').val();
              var periode_end   = $('#periode_end').val();
              var pelanggan = $('#pelanggan').val();
   
                function load_grafik()
                {
                    $.ajax({
                        type: 'POST',
                        url: App.baseUrl+"dashboard/total_minggu_ini",
                        data: {
                            periode_start: periode_start,
                            periode_end  : periode_end,
                            pelanggan    : pelanggan,
                        },
                        success: function(data){
                        
                            var objek_JSON=jQuery.parseJSON(data)
                        
                            
                            $.each(objek_JSON, function(index, nilai){
                                if(index=='tanggal'){
                                    options.xAxis.categories=nilai;
                                }
                                if(index=='total'){
                                    options.series[0].name = 'Omset';
                                    options.series[0].data = nilai;
                                  
                                }
                                   
                                
                                         })
                            chart = new Highcharts.Chart(options);   
                              /// tes = new totaldata;
                          

                        }
                    });
                };
                load_grafik();


                  function datalist()
                {
                    $.ajax({
                        type: 'POST',
                        url: App.baseUrl+"dashboard/totalharga",
                        data: {
                            periode_start: periode_start,
                            periode_end  : periode_end,
                            pelanggan    : pelanggan,
                        },
                     success:function(r){
                      var r = JSON.parse(r); 
                        var element = '';
                        var data = r.data;
                        //console.log(data);

                        
                          for (var i = 0; i < data.length; i++) {
                            if(data.length > 0){
                        element+= data[i].total;
                            }else{
                      element+='0';  
                          

                            }
                        }
                       var harga = convertToRupiah(element);

                        $('#totalHarga').html(harga);
                      
                 }
                    });
                };
                datalist();

                   function dataCS()
                {
                    $.ajax({
                        type: 'POST',
                        url: App.baseUrl+"dashboard/totalhargaCS",
                        data: {
                            periode_start: periode_start,
                            periode_end  : periode_end,
                            pelanggan    : pelanggan,
                        },
                     success:function(r){
                      var r = JSON.parse(r); 
                        var element = '';
                        var data = r.data;
                       // console.log(data);
                  element = '<table class="table table-bordered"><thead><tr role="row"><th>Customer</th><th>Total</th></tr></thead><tbody>';
                        
                          for (var i = 0; i < data.length; i++) {
                            if(data.length > 0){
                element+= '<tr><td>'+data[i].nama+'</td><td>'+data[i].total+'</td></tr>';
                
                            }else{
                     element+='<span>0</span>';  
                          

                            }
                        }
                     //   var harga = convertToRupiah(element);

                        $('#totalHargaCS').html(element);
                      
                 }
                    });
                };
                dataCS();

                function convertToRupiah(angka)
       {
        var rupiah = '';        
        var angkarev = angka.toString().split('').reverse().join('');
        for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
        return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
       }
             
          $("#pelanggan").select2({
                placeholder: "Pilih Customer",
            });
        }, 

        initDatePicker : function(){   
            var valueSet1 = function(start, end, label) {
              $('#daterange-btn span').html(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
            };

            var optionSet1 = {
              startDate: moment().subtract(6, 'days'),
              endDate: moment(),
              minDate: '01/01/2015',
              maxDate: moment(),
              dateLimit: {
                days: 60
              },
              showDropdowns: true,
              showWeekNumbers: true,
              timePicker: false,
              timePickerIncrement: 1,
              timePicker12Hour: true,
              ranges: {
                '3 hari terakhir': [moment().subtract(2, 'days'), moment()],
                '7 hari terakhir': [moment().subtract(6, 'days'), moment()],
                '30 hari terakhir': [moment().subtract(29, 'days'), moment()],
                'Bulan ini': [moment().startOf('month'), moment().endOf('month')],
                'Bulan kemarin': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
              },

              opens: 'left',
              format: 'DD/MM/YYYY',
              separator: ' to ',
              locale: {
                applyLabel: 'Submit',
                cancelLabel: 'Clear',
                fromLabel: 'From',
                toLabel: 'To',
                customRangeLabel: 'Custom',
                daysOfWeek: ['Mg', 'Sn', 'Sl', 'Rb', 'Km', 'Jm', 'Sb'],
                monthNames: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Juni', 'Juli', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
                firstDay: 1
              }
            };

            $('#daterange-btn span').html(moment().subtract(6, 'days').format('DD MMM YYYY') + ' - ' + moment().format('DD MMM YYYY'));
            $('#periode_start').val(moment().subtract(6, 'days').format('YYYY-MM-DD'));
            $('#periode_end').val(moment().format('YYYY-MM-DD'));
            $('#daterange-btn').daterangepicker(optionSet1, valueSet1);
            $('#reportrange').on('show.daterangepicker', function() {
              console.log("show event fired");
            });
            $('#daterange-btn').on('apply.daterangepicker', function(ev, picker) {
                $('#periode_start').val(picker.startDate.format('YYYY-MM-DD'));
                $('#periode_end').val(picker.endDate.format('YYYY-MM-DD'));
                
                var periode_start = $('#periode_start').val();
                var periode_end   = $('#periode_end').val();
                var pelanggan        = $('#pelanggan').val();

                App.table.column(1).search(pelanggan,true,true);
                App.table.column(2).search(periode_start,true,true);
                App.table.column(3).search(periode_end,true,true);
                App.table.draw();

                $.ajax({
                    type: 'POST',
                    url: App.baseUrl+"dashboard/total_minggu_ini",
                    data: {
                        periode_start : periode_start,
                        periode_end   : periode_end,
                        pelanggan        : pelanggan,
                    },
                    dataType : "json",
                    success: function(data){
                        App.initEvent(); 
                       
                    }
                });
            }); 

              $('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
              
              
            $("#pelanggan")[0].selectedIndex = 0; 
             
            }); 
              $('#pelanggan').on('change', function() {
             //   $('#periode_start').val(picker.startDate.format('YYYY-MM-DD'));
             //   $('#periode_end').val(picker.endDate.format('YYYY-MM-DD'));
                
                var periode_start = $('#periode_start').val();
                var periode_end   = $('#periode_end').val();
                var pelanggan        = $('#pelanggan').val();
                $.ajax({
                    type: 'POST',
                    url: App.baseUrl+"dashboard/total_minggu_ini",
                    data: {
                        periode_start : periode_start,
                        periode_end   : periode_end,
                        pelanggan        : pelanggan,
                    },
                    dataType : "json",
                    success: function(data){
                        App.initEvent(); 
                        
                    }
                });
            });   
        },
        
              initSearchINV : function(){  
           $('#cari_tujuan_darat').on('click', function () {
               var tujuan_darat = $("#tujuan_darat").val();
               var tujuan_laut = $("#tujuan_laut").val();
               var tujuan_udara = $("#tujuan_udara").val();
               App.table.column(1).search(tujuan_darat,true,true);
              App.table.column(2).search(tujuan_laut,false,false);
              App.table.column(3).search(tujuan_udara,false,false);
              App.table.draw();
              console.log(tujuan_darat);
             $('#tableDaftarHarga').removeClass('hide');
                  
              
                 if(tujuan_darat === ""){
                    var element = '';   
                  }else{
                     var element = '<i class="fa fa-truck"> Pengiriman Jalur Darat Tujuan - '+tujuan_darat+'</i>';
                  }
               $('#head_tujuan').html(element);
                
            });
              $('#cari_tujuan_laut').on('click', function () {
               var tujuan_darat = $("#tujuan_darat").val("");
               var tujuan_laut = $("#tujuan_laut").val();
               var tujuan_udara = $("#tujuan_udara").val("");
               App.table.column(1).search(tujuan_darat,false,false);
               App.table.column(2).search(tujuan_laut,true,true);
              App.table.column(3).search(tujuan_udara,false,false);
               App.table.draw();
               $('#tableDaftarHarga').removeClass('hide');
                  
              
                 if(tujuan_laut === ""){
                    var element = '';   
                  }else{
                     var element = '<i class="fa fa-ship"> Pengiriman Jalur Laut Tujuan - '+tujuan_laut+'</i>';
                  }
               $('#head_tujuan').html(element);
                
            });
                 $('#cari_tujuan_udara').on('click', function () {
               var tujuan_darat = $("#tujuan_darat").val("");
               var tujuan_laut = $("#tujuan_laut").val("");
               var tujuan_udara = $("#tujuan_udara").val();
               App.table.column(1).search(tujuan_darat,false,false);
               App.table.column(2).search(tujuan_laut,false,false);
              App.table.column(3).search(tujuan_udara,true,true);
               App.table.draw();
                  $('#tableDaftarHarga').removeClass('hide');
              
                 if(tujuan_udara === ""){
                    var element = '';   
                  }else{
                     var element = '<i class="fa fa-plane"> Pengiriman Jalur Udara Tujuan - '+tujuan_udara+'</i>';
                  }
               $('#head_tujuan').html(element);
                
            });
            
           $('#transaksiTinggiData').on('click', function () {
          $('#transaksi_tertinggi').removeClass('hide');  
            });

             $('#search').on('click', function () {
                $.ajax({
                 url: App.baseUrl+'Dashboard/getINV',
                 type : 'GET',
                 data : { inv:$("#inv").val()},
                 success:function(r){
                      var r = JSON.parse(r); 
                        var element = '<table class="table table-bordered"><tbody><tr><th style="width: 50px"></th><th>Tanggal</th><th>Status Pengiriman</th></tr>';
                        var data = r.data;
                       // console.log(data);

                        
                          for (var i = 0; i < data.length; i++) {
                            if(data.length > 0){
                        element+= '<tr style="text-align:left"><td style="width: 50px"></td><td>'+data[i].tanggal+'</td><td>'+data[i].status_pengiriman+' - '+data[i].pengiriman+'</td></tr><tbody</table>';
                            }else{
                      element+='data kosong';  
                          

                            }
                        }

                        $('#hasilTracking').html(element);
                      
                 }
                 
                });
               
                
            });
              }

	}
});