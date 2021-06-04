require(["../common" ], function (common) {  
    require(["main-function","../app/app-invoice_allvendor"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});