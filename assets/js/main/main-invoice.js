require(["../common" ], function (common) {  
    require(["main-function","../app/app-invoice"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});