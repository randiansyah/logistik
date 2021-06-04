require(["../common" ], function (common) {  
    require(["main-function","../app/app-daftar-harga"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});