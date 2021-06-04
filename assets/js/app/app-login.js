define([
    "jQuery",
	"bootstrap",
    "jqvalidate",
    "datatables",
    "uiForm"
	], function (
    $,
	bootstrap,
    jqvalidate,
    datatables,
    uiForm
	) {
    return {  
        init: function () { 
        	App.initFunc();
            App.initEvent(); 
            console.log("loaded");
            $(".loadingpage").hide();
		},
         
        initEvent : function(){  
            $("#btn-login").removeAttr("disabled");
            $("#form-login").validate({ 
                rules: {
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    username: {
                        required: "Username is Required"
                    },
                    password: {
                        required: "Password is Required"
                    }
                }, 
                debug:true,
                
                errorPlacement: function(error, element) {
                    var name = element.attr('name');
                    var errorSelector = '.form-control-feedback[for="' + name + '"]';
                    var $element = $(errorSelector);
                    if ($element.length) { 
                        $(errorSelector).html(error.html());
                    } else {
                        error.insertAfter(element);
                    }
                },
                submitHandler : function(form) { 
                    form.submit();
                }
            });
        }
	}
});