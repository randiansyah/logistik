require(["../common" ], function (common) {  
    require(["main-function","../app/app-login"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});