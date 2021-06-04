require(["../common" ], function (common) {  
    require(["main-function","../app/app-privilleges"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});