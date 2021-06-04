require(["../common" ], function (common) {  
    require(["main-function","../app/app-cabang"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});