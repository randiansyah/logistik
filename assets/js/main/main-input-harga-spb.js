require(["../common" ], function (common) {  
    require(["main-function","../app/app-main-input-harga-spb"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});