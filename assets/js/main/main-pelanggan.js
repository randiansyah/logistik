require(["../common" ], function (common) {  
    require(["main-function","../app/app-pelanggan"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});