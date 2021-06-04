require(["../common" ], function (common) {  
    require(["main-function","../app/app-jadwal-pickup"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});