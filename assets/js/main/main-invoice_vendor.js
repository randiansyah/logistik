require(["../common" ], function (common) {  
    require(["main-function","../app/app-invoiceV"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});