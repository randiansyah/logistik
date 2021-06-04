require(["../common" ], function (common) {  
    require(["main-function","../app/app-konfirmasi_pesanan"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});