require(["../common" ], function (common) {  
    require(["main-function","../app/app-wilayah"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});