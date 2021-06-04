
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
        tableRincian:null,
        tableTransaksi:null,
        init: function () { 
          App.initFunc(); 
        App.initEvent(); 

            App.initDatePicker(); 
            App.initNewTable();
            //console.log("LOADED");
            
    }, 
        initNewTable : function(){
      
          var suburl = $('#suburl').val();
            var periode_start = $('#periode_start').val();
            var periode_end   = $('#periode_end').val();
             
            App.table = $('#table').DataTable({
              "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // converting to interger to find total
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // computing column Total of the complete result 
            var total_kredit = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var total_cash = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 ); var total_grand = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                 var jatuh_tempo = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var bayar_kredit = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var bayar_cash = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
                var total_bayar = api
                .column( 8 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
var display = $.fn.dataTable.render.number( '.', ',', 0, 'Rp.' ).display;       
var t_kredit = display( total_kredit );  
$('#total_kredit').html(t_kredit);
var t_cash = display( total_cash );  
$('#total_cash').html(t_cash);
var t_grand = display( total_grand );  
$('#grand_total').html(t_grand);
var t_tempo = display( jatuh_tempo );  
$('#jatuh_tempo').html(t_tempo);
var b_kredit = display( bayar_kredit );  
$('#bayar_kredit').html(b_kredit);
var b_cash = display( bayar_cash );  
$('#bayar_cash').html(b_cash);
var total = display( total_bayar );  
$('#total_bayar').html(total);
                     // Update footer by showing the total with the reference of the column index 
      $( api.column( 0 ).footer() ).html('Total');
      $( api.column( 2 ).footer() ).html(t_kredit);
      $( api.column( 3 ).footer() ).html(t_cash);
      $( api.column( 4 ).footer() ).html(t_grand);
      $( api.column( 5 ).footer() ).html(t_tempo);
      $( api.column( 6 ).footer() ).html(b_kredit);
      $( api.column( 7 ).footer() ).html(b_cash);
      $( api.column( 8 ).footer() ).html(total);

        },
        
               "processing": true,
                "serverSide": true,
                "dom": "Bfrltip",
                "pageLength": 100,
    "lengthMenu": [0, 5, 10, 20, 50, 100, 200, 500],
                "ajax":{
                    "url": App.baseUrl+suburl+"/datalist",
                    "dataType": "json",
                    "type": "POST",
                     "data": function(data){
                           data.id = $('#id').val();
                          data.periode_start = $('#periode_start').val();
                          data.periode_end   = $('#periode_end').val();
      
                           
                    }
                  
                },
                "columns": [
                   { "data": "id" },
                     { "data": "nama" },
                     { "data": "total_kredit",render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp.' )},
                     { "data": "total_cash",render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp.' ) },  
                     { "data": "grand_total",render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp.' ) },   
                    { "data": "jatuh_tempo",render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp.' ) },
                    { "data": "total_kredit_bayar",render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp.' ) },  
                     { "data": "total_cash_bayar",render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp.' ) },   
                            { "data": "total_bayar",render: $.fn.dataTable.render.number( '.', ',', 0, 'Rp.' ) },                     
                   
                ],
               "order": [[0, 'desc']]
               
            });

               App.tableRincian = $('#tableRincian').DataTable({
                  language: {
                    paginate: {
                        next: false,
                        previous: false
                    }
                },
              
                "processing": true,
                "serverSide": true,
              "pageLength": 100,
    "lengthMenu": [0, 5, 10, 20, 50, 100, 200, 500],
                "ajax":{
                    "url": App.baseUrl+suburl+"/dataList_rincian",
                    "dataType": "json",
                    "type": "POST",
                     "data": function(data){
                           data.id = $('#id').val();
                          data.periode_start = $('#periode_start').val();
                          data.periode_end   = $('#periode_end').val();
      
                           
                    }
                  
                },
                "columns": [
                    { "data": "id" },
                    { "data": "id_transaksi" },
                    { "data": "pickup" },
                    { "data": "nama" },
                    { "data": "total_harga" },
                    { "data": "tgl_sekarang" },
                    { "data": "tgl_jatuh_tempo" },
                    { "data": "hari_terlewati" }, 
                ],
               "order": [[0, 'desc']]
             
            });


        },
    initEvent : function(){ 
         $('.select2').select2();
                
              var periode_start = $('#periode_start').val();
              var periode_end   = $('#periode_end').val();
             
             
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
         
                App.table.column(1).search(periode_start,true,true);
                App.table.column(2).search(periode_end,true,true);
                App.table.draw();

                 App.tableRincian.column(1).search(periode_start,true,true);
                App.tableRincian.column(2).search(periode_end,true,true);
                App.tableRincian.draw();
  var uri = '';   
  var uri_rincian = '';   
           // buat export csv
           //uri+= '';
           var kode_pelanggan = $('#kode_pelanggan').val();
		   
		   
                var suburl = $('#suburl').val();
              uri+= '/'+periode_start+'/'+periode_end;  
              uri_rincian+= '/'+kode_pelanggan+'/'+periode_start+'/'+periode_end;  
                var url = App.baseUrl+suburl+'/pdf'+uri;
                var url_rincian = App.baseUrl+suburl+'/pdf_rincian'+uri_rincian;
                $('#print-pdf').attr({href  : url});
				
				
               // $('#print-pdf-rincian').attr({href  : url_rincian});
               
          
            }); 

              $('#daterange-btn').on('cancel.daterangepicker', function(ev, picker) {
              
              
            $("#pelanggan")[0].selectedIndex = 0; 
             
            }); 
         
        },
        
         

  }
});