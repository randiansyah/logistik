require(["../common" ], function (common) {  
    require(["main-function","../app/app-manifest"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});