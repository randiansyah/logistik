require(["../common" ], function (common) {  
    require(["main-function","../app/app-group"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});