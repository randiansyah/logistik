require(["../common" ], function (common) {  
    require(["main-function","../app/app-forgot-password"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});