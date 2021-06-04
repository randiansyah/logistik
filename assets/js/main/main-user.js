require(["../common" ], function (common) {  
    require(["main-function","../app/app-user"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});