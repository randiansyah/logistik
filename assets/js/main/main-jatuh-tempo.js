require(["../common" ], function (common) {  
    require(["main-function","../app/app-jatuh-tempo"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});