require(["../common" ], function (common) {  
    require(["main-function","../app/app-profile"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});