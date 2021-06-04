require(["../common" ], function (common) {  
    require(["main-function","../app/app-role"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});