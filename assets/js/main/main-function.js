define(['jQuery'], function ($) {
    return { 
        clickEvent               : "click", 
        loading                  : $("#loading"),
        baseUrl                  : document.getElementById("base_url").value,
        initFunc    : function () {
            App.initValidationForm();  
        }, 
        initValidationForm :function(){
            $('.numeric').on("input", function() {
                this.value = this.value.replace(/[^\d\.\-]/g,'');
            });

              $('.harga').on("input", function() {
                this.value = formatRupiah(this.value,'Rp. ');
            });
            // formatRupiah untuk konversi ke rupiah
            function formatRupiah(angka, prefix)
            {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split   = number_string.split(','),
                    sisa    = split[0].length % 3,
                    rupiah  = split[0].substr(0, sisa),
                    ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
                    
                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                
                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }
        },
        alert       : function(msg, callback){
            $("#alert_modal .modal-title").text("");
            // if (title != undefined && title != false && title != "") {
            //     $("#alert_modal .modal-title").text(title);
            // }
            $(".alert-msg").text(msg);
            $(".alert-cancel").hide();
            $(".alert-ok").show(); 

            $('#alert_modal').modal('show');

            $("#alert_modal .alert-ok").bind(App.clickEvent, function (e) {
                if (callback != undefined && callback != null && callback != false) {
                    callback();
                }
             
                setTimeout(function() {
                    $("#alert_modal").modal("hide");
                }, 200);
                
                e.preventDefault(); 
                $(this).unbind();
            }); 
        }, 
        confirm       : function(msg, callbackOk, callbackCancel){
            $("#alert_modal .modal-title").text("");
            // if (title != undefined && title != false && title != "") {
            //     $("#alert_modal .modal-title").text(title);
            // }

            $(".alert-msg").text(msg);
            $(".alert-cancel").show();
            $(".alert-ok").show(); 

            $('#alert_modal').modal('show');

            $("#alert_modal .alert-ok").bind(App.clickEvent, function (e) {
                if (callbackOk != undefined && callbackOk != null && callbackOk != false) {
                    callbackOk();
                }
                setTimeout(function() {
                    $("#alert_modal").modal("hide");
                }, 200);
                
                e.preventDefault();
                $(this).unbind();
                $("#alert_modal .alert-cancel").unbind();
            });

            $("#alert_modal .alert-cancel").bind(App.clickEvent, function (e) {
                if (callbackCancel != undefined && callbackCancel != null && callbackCancel != false) {
                    callbackCancel();
                }
                setTimeout(function() {
                    $("#alert_modal").modal("hide");
                }, 200);
                
                e.preventDefault();
                $(this).unbind();
                $("#alert_modal .alert-ok").unbind();
            });
        }, 
        approval       : function(msg, callbackOk, callbackCancel){
            $("#alert_approval .modal-title").text(""); 

            $(".alert-msg").text(msg);
            $(".alert-cancel").show();
            $(".alert-reject").show();
            $(".alert-approve").show(); 

            $('#alert_approval').modal('show');
            $("#alert_approval .alert-cancel").bind(App.clickEvent, function (e) { 
                setTimeout(function() {
                    $("#alert_approval").modal("hide");
                }, 200);
                
                e.preventDefault();
                $(this).unbind();
                $("#alert_approval .alert-approve").unbind();
            });
            $("#alert_approval .alert-approve").bind(App.clickEvent, function (e) {
                if (callbackOk != undefined && callbackOk != null && callbackOk != false) {
                    callbackOk();
                }
                setTimeout(function() {
                    $("#alert_approval").modal("hide");
                }, 200);
                
                e.preventDefault();
                $(this).unbind();
                $("#alert_approval .alert-cancel").unbind();
            }); 

            $("#alert_approval .alert-reject").bind(App.clickEvent, function (e) {
                if (callbackCancel != undefined && callbackCancel != null && callbackCancel != false) {
                    callbackCancel();
                }
                setTimeout(function() {
                    $("#alert_approval").modal("hide");
                }, 200);
                
                e.preventDefault();
                $(this).unbind();
                $("#alert_approval .alert-ok").unbind();
            });
        }, 
    }
});