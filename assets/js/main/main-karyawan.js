require(["../common" ], function (common) {  
    require(["main-function","../app/app-karyawan"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});