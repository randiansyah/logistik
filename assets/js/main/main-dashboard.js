require(["../common" ], function (common) {  
    require(["main-function","../app/app-dashboard"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});