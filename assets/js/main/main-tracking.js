require(["../common" ], function (common) {  
    require(["main-function","../app/app-tracking"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});