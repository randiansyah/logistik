require(["../common" ], function (common) {  
    require(["main-function","../app/app-spb"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});