require(["../common" ], function (common) {  
    require(["main-function","../app/app-vendor"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});